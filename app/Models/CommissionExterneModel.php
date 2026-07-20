<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionExterneModel extends Model
{
    protected $table         = 'commission_externe';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['prefixe_id', 'taux_pourcentage'];

    public function tauxPourPrefixe(int $prefixeId): float
    {
        $ligne = $this->where('prefixe_id', $prefixeId)->first();

        return $ligne ? (float) $ligne['taux_pourcentage'] : 0.0;
    }
}
