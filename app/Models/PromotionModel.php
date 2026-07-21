<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table         = 'promotion';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false;
    protected $allowedFields = ['libelle', 'pourcentage', 'actif'];

    /**
     * Une seule promo active a la fois (la plus recente si plusieurs actif=1).
     */
    public function promotionActive(): ?array
    {
        return $this->where('actif', 1)
                     ->orderBy('id', 'DESC')
                     ->first();
    }
}
