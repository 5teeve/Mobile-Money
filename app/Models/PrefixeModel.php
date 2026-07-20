<?php

namespace App\Models;

use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table         = 'prefixe';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['prefixe', 'actif'];

    public function estActif(string $prefixe): bool
    {
        return (bool) $this->where('prefixe', $prefixe)
                            ->where('actif', 1)
                            ->first();
    }
    protected $validationRules = [
        'prefixe' => 'required|exact_length[3]|numeric|is_unique[prefixe.prefixe,id,{id}]',
        'actif' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'prefixe' => [
            'required' => 'Le préfixe est requis.',
            'exact_length' => 'Le préfixe doit contenir exactement 3 chiffres.',
            'numeric' => 'Le préfixe doit être numérique.',
            'is_unique' => 'Ce préfixe existe déjà.',
        ],
    ];
}

