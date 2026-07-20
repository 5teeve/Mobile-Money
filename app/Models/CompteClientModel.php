<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteClientModel extends Model
{
    protected $table         = 'compte_client';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['numero_telephone', 'solde', 'date_creation'];

    public function findOrCreate(string $numero): array
    {
        $compte = $this->where('numero_telephone', $numero)->first();

        if (! $compte) {
            $id     = $this->insert(['numero_telephone' => $numero, 'solde' => 0]);
            $compte = $this->find($id);
        }

        return $compte;
    }
}
