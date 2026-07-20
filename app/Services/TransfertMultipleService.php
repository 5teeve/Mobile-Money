<?php

namespace App\Services;

use App\Exceptions\OperationException;
use App\Models\BaremeModel;
use App\Models\CommissionExterneModel;
use App\Models\CompteClientModel;
use App\Models\OperationModel;
use App\Models\PrefixeModel;
use App\Models\TypeOperationModel;
use Config\Database;

class TransfertMultipleService
{
    private CompteClientModel $compteModel;
    private TypeOperationModel $typeOperationModel;
    private BaremeModel $baremeModel;
    private OperationModel $operationModel;
    private PrefixeModel $prefixeModel;
    private CommissionExterneModel $commissionExterneModel;

    public function __construct()
    {
        $this->compteModel = new CompteClientModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeModel = new BaremeModel();
        $this->operationModel = new OperationModel();
        $this->prefixeModel = new PrefixeModel();
        $this->commissionExterneModel = new CommissionExterneModel();
    }

    /**
     * Envoie un montant total divise a parts egales vers plusieurs numeros,
     * tous chez le meme operateur, en une seule transaction globale.
     *
     * @param string[] $numerosDestination
     *
     * @return array{montant_total: float, frais_total: float, details: array}
     */
    public function envoyer(array $compteSource, array $numerosDestination, float $montantTotal, bool $inclureFraisRetrait): array
    {
        $numerosDestination = array_values(array_unique(array_filter($numerosDestination)));

        if (count($numerosDestination) < 2) {
            throw new OperationException('Indiquez au moins deux numeros pour un envoi multiple.');
        }

        if (in_array($compteSource['numero_telephone'], $numerosDestination, true)) {
            throw new OperationException('Impossible de se transferer a soi-meme.');
        }

        // meme operateur uniquement : tous les numeros doivent partager le meme prefixe
        $prefixeReference = null;
        foreach ($numerosDestination as $numero) {
            $prefixe = $this->prefixeModel->trouverPourNumero($numero);

            if (!$prefixe) {
                throw new OperationException("Prefixe non reconnu pour le numero {$numero}.");
            }

            if ($prefixeReference === null) {
                $prefixeReference = $prefixe;
            } elseif ((int) $prefixe['id'] !== (int) $prefixeReference['id']) {
                throw new OperationException('Tous les numeros doivent appartenir au meme operateur.');
            }
        }

        $estExterne = $prefixeReference['categorie'] === 'externe';
        if ($estExterne) {
            $inclureFraisRetrait = false;
        }

        // split du montant a parts egales, le reste (arrondi) est ajoute au dernier numero
        $nb = count($numerosDestination);
        $part = floor(($montantTotal / $nb) * 100) / 100;
        $reste = round($montantTotal - ($part * $nb), 2);

        $typeTransfert = $this->recupererType('TRANSFERT');
        $typeRetrait = $inclureFraisRetrait ? $this->recupererType('RETRAIT') : null;

        $tauxCommissionExterne = $estExterne
            ? $this->commissionExterneModel->tauxPourPrefixe((int) $prefixeReference['id'])
            : 0.0;

        $details = [];
        $totalDebit = 0.0;
        $fraisTotal = 0.0;

        foreach ($numerosDestination as $i => $numero) {
            $montantPart = $part + ($i === $nb - 1 ? $reste : 0.0);

            $fraisTransfert = $this->baremeModel->calculerFrais((int) $typeTransfert['id'], $montantPart);
            $fraisRetrait = $typeRetrait
                ? $this->baremeModel->calculerFrais((int) $typeRetrait['id'], $montantPart)
                : 0.0;
            $commissionExterne = $estExterne ? round($montantPart * $tauxCommissionExterne / 100, 2) : 0.0;

            $fraisPart = $fraisTransfert + $fraisRetrait + $commissionExterne;
            $montantCredite = $montantPart + $fraisRetrait;

            $details[] = [
                'numero' => $numero,
                'montant' => $montantPart,
                'frais' => $fraisPart,
                'montant_credite' => $montantCredite,
            ];

            $totalDebit += $montantPart + $fraisPart;
            $fraisTotal += $fraisPart;
        }

        if ($totalDebit > (float) $compteSource['solde']) {
            throw new OperationException("Solde insuffisant (montant + frais = {$totalDebit} Ar).");
        }

        $db = Database::connect();
        $db->transStart();

        $this->compteModel->debiter((int) $compteSource['id'], $totalDebit);

        foreach ($details as $detail) {
            $compteDestination = $this->compteModel->findOrCreate($detail['numero']);

            $this->compteModel->crediter((int) $compteDestination['id'], $detail['montant_credite']);

            $this->operationModel->insert([
                'type_operation_id' => $typeTransfert['id'],
                'compte_source_id' => $compteSource['id'],
                'compte_destination_id' => $compteDestination['id'],
                'montant' => $detail['montant'],
                'frais' => $detail['frais'],
            ]);
        }

        $this->finaliser($db);

        return [
            'montant_total' => $montantTotal,
            'frais_total' => round($fraisTotal, 2),
            'details' => $details,
        ];
    }

    private function recupererType(string $code): array
    {
        $type = $this->typeOperationModel->where('code', $code)->first();

        if (!$type) {
            throw new OperationException("Type d'operation {$code} non configure.");
        }

        return $type;
    }

    private function finaliser($db): void
    {
        $db->transComplete();

        if ($db->transStatus() === false) {
            throw new OperationException('Echec de la transaction, reessayez.');
        }
    }
}