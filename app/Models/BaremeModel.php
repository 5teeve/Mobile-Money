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

    public function calculerFrais(int $typeOperationId, float $montant): float
    {
        $bareme = $this->where('type_operation_id', $typeOperationId)
                        ->where('montant_min <=', $montant)
                        ->where('montant_max >=', $montant)
                        ->first();

        return $bareme ? (float) $bareme['frais'] : 0.0;
    }
}
