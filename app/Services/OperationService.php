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

class OperationService
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
     * @return array{montant: float, frais: float}
     */
    public function depot(array $compte, float $montant): array
    {
        $type = $this->recupererType('DEPOT');

        $db = Database::connect();
        $db->transStart();

        $this->compteModel->crediter((int) $compte['id'], $montant);

        $this->operationModel->insert([
            'type_operation_id' => $type['id'],
            'compte_source_id' => null,
            'compte_destination_id' => $compte['id'],
            'montant' => $montant,
            'frais' => 0,
        ]);

        $this->finaliser($db);

        return ['montant' => $montant, 'frais' => 0.0];
    }

    /**
     * @return array{montant: float, frais: float}
     */
    public function retrait(array $compte, float $montant): array
    {
        $type = $this->recupererType('RETRAIT');
        $frais = $this->baremeModel->calculerFrais((int) $type['id'], $montant);
        $total = $montant + $frais;

        if ($total > (float) $compte['solde']) {
            throw new OperationException("Solde insuffisant (montant + frais = {$total} Ar).");
        }

        $db = Database::connect();
        $db->transStart();

        $this->compteModel->debiter((int) $compte['id'], $total);

        $this->operationModel->insert([
            'type_operation_id' => $type['id'],
            'compte_source_id' => $compte['id'],
            'compte_destination_id' => null,
            'montant' => $montant,
            'frais' => $frais,
        ]);

        $this->finaliser($db);

        return ['montant' => $montant, 'frais' => $frais];
    }

    /**
     * @return array{montant: float, frais: float, externe: bool, epargne: float}
     */
    public function transfert(array $compteSource, string $numeroDestination, float $montant, bool $inclureFraisRetrait): array
    {
        if ($numeroDestination === $compteSource['numero_telephone']) {
            throw new OperationException('Impossible de se transferer a soi-meme.');
        }

        $prefixeDestination = $this->prefixeModel->trouverPourNumero($numeroDestination);
        if (!$prefixeDestination) {
            throw new OperationException('Prefixe du destinataire non reconnu.');
        }

        $estExterne = $prefixeDestination['categorie'] === 'externe';

        // pas de frais de retrait pour les autres operateurs
        if ($estExterne) {
            $inclureFraisRetrait = false;
        }

        $typeTransfert = $this->recupererType('TRANSFERT');
        $fraisTransfert = $this->baremeModel->calculerFrais((int) $typeTransfert['id'], $montant);

        $fraisRetrait = 0.0;
        if ($inclureFraisRetrait) {
            $typeRetrait = $this->recupererType('RETRAIT');
            $fraisRetrait = $this->baremeModel->calculerFrais((int) $typeRetrait['id'], $montant);
        }

        $commissionExterne = 0.0;
        if ($estExterne) {
            $taux = $this->commissionExterneModel->tauxPourPrefixe((int) $prefixeDestination['id']);
            $commissionExterne = round($montant * $taux / 100, 2);
        }

        $tauxEpargne = (float) ($compteSource['taux_epargne'] ?? 0);
        $montantEpargne = $tauxEpargne > 0 ? round($montant * $tauxEpargne / 100, 2) : 0.0;

        $fraisTotal = $fraisTransfert + $fraisRetrait + $commissionExterne;
        $totalDebit = $montant + $fraisTotal + $montantEpargne;

        if ($totalDebit > (float) $compteSource['solde']) {
            throw new OperationException("Solde insuffisant (montant + frais + epargne = {$totalDebit} Ar).");
        }

        $compteDestination = $this->compteModel->findOrCreate($numeroDestination);
        $montantCredite = $montant + $fraisRetrait; 

        $db = Database::connect();
        $db->transStart();

        $this->compteModel->debiter((int) $compteSource['id'], $totalDebit);
        $this->compteModel->crediter((int) $compteDestination['id'], $montantCredite);

        if ($montantEpargne > 0) {
            $this->compteModel->crediterEpargne((int) $compteSource['id'], $montantEpargne);
        }

        $this->operationModel->insert([
            'type_operation_id' => $typeTransfert['id'],
            'compte_source_id' => $compteSource['id'],
            'compte_destination_id' => $compteDestination['id'],
            'montant' => $montant,
            'frais' => $fraisTotal,
        ]);

        $this->finaliser($db);

        return ['montant' => $montant, 'frais' => $fraisTotal, 'externe' => $estExterne, 'epargne' => $montantEpargne];
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
