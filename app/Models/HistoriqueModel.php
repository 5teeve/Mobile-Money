<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoriqueModel extends Model
{
    protected $table         = 'vue_historique';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;

    public function findByCompte(int $compteId): array
    {
        return $this->groupStart()
                        ->where('compte_source_id', $compteId)
                        ->orWhere('compte_destination_id', $compteId)
                    ->groupEnd()
                    ->orderBy('date_operation', 'DESC')
                    ->findAll();
    }
}
