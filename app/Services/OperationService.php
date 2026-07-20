<?php

namespace App\Services;

use App\Exceptions\OperationException;
use App\Models\BaremeModel;
use App\Models\CompteClientModel;
use App\Models\OperationModel;
use App\Models\TypeOperationModel;
use Config\Database;

class OperationService
{
    private CompteClientModel $compteModel;
    private TypeOperationModel $typeOperationModel;
    private BaremeModel $baremeModel;
    private OperationModel $operationModel;

    public function __construct()
    {
        $this->compteModel        = new CompteClientModel();
        $this->typeOperationModel = new TypeOperationModel();
        $this->baremeModel        = new BaremeModel();
        $this->operationModel     = new OperationModel();
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
            'type_operation_id'     => $type['id'],
            'compte_source_id'      => null,
            'compte_destination_id' => $compte['id'],
            'montant'               => $montant,
            'frais'                 => 0,
        ]);

        $this->finaliser($db);

        return ['montant' => $montant, 'frais' => 0.0];
    }

    /**
     * @return array{montant: float, frais: float}
     */
    public function retrait(array $compte, float $montant): array
    {
        $type  = $this->recupererType('RETRAIT');
        $frais = $this->baremeModel->calculerFrais((int) $type['id'], $montant);
        $total = $montant + $frais;

        if ($total > (float) $compte['solde']) {
            throw new OperationException("Solde insuffisant (montant + frais = {$total} Ar).");
        }

        $db = Database::connect();
        $db->transStart();

        $this->compteModel->debiter((int) $compte['id'], $total);

        $this->operationModel->insert([
            'type_operation_id'     => $type['id'],
            'compte_source_id'      => $compte['id'],
            'compte_destination_id' => null,
            'montant'               => $montant,
            'frais'                 => $frais,
        ]);

        $this->finaliser($db);

        return ['montant' => $montant, 'frais' => $frais];
    }

    private function recupererType(string $code): array
    {
        $type = $this->typeOperationModel->where('code', $code)->first();

        if (! $type) {
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
