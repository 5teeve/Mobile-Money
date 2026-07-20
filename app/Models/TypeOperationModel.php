<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeOperationModel extends Model
{
    protected $table         = 'type_operation';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['code', 'libelle'];

      protected $validationRules = [
        'code' => 'required|in_list[DEPOT,RETRAIT,TRANSFERT]|is_unique[type_operation.code,id,{id}]',
        'libelle' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'code' => [
            'in_list' => 'Le code doit être DEPOT, RETRAIT ou TRANSFERT.',
            'is_unique' => 'Ce code existe déjà.',
        ],
    ];
}

