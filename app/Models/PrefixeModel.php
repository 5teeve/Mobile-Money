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
}
