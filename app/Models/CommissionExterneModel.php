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

    protected $validationRules = [
        'prefixe_id' => 'required|is_natural_no_zero|is_unique[commission_externe.prefixe_id,id,{id}]',
        'taux_pourcentage' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
    ];

    public function getAvecPrefixe(): array
    {
        return $this->select('commission_externe.*, prefixe.prefixe AS prefixe')
                    ->join('prefixe', 'prefixe.id = commission_externe.prefixe_id')
                    ->findAll();
    }
}
