<?php

namespace App\Models;

use CodeIgniter\Model;

class BaremeModel extends Model
{
    protected $table         = 'bareme';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['type_operation_id', 'montant_min', 'montant_max', 'frais'];

    /**
     * Retourne le frais applicable pour un type d'operation et un montant donnes.
     * 0.0 si aucune tranche ne correspond (ex: type sans frais).
     */
    public function calculerFrais(int $typeOperationId, float $montant): float
    {
        $bareme = $this->where('type_operation_id', $typeOperationId)
                        ->where('montant_min <=', $montant)
                        ->where('montant_max >=', $montant)
                        ->first();

        return $bareme ? (float) $bareme['frais'] : 0.0;
    }

      protected $validationRules = [
        'type_operation_id' => 'required|is_natural_no_zero',
        'montant_min' => 'required|numeric',
        'montant_max' => 'required|numeric',
        'frais' => 'required|numeric',
    ];

    public function getByType(int $typeOperationId): array
    {
        return $this->where('type_operation_id', $typeOperationId)
                    ->orderBy('montant_min', 'ASC')
                    ->findAll();
    }

    public function findTranche(int $typeOperationId, float $montant): ?array
    {
        return $this->where('type_operation_id', $typeOperationId)
                    ->where('montant_min <=', $montant)
                    ->where('montant_max >=', $montant)
                    ->first();
    }
}
