<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SituationController extends BaseController
{
    public function gains()
    {
        $db = db_connect();

        $gains = $db->table('vue_situation_gains')
                     ->orderBy('jour', 'DESC')
                     ->get()
                     ->getResultArray();

        $totalInterne = 0.0;
        $totalExterne = 0.0;

        foreach ($gains as $gain) {
            $totalFrais = (float) ($gain['total_frais'] ?? 0);

            if (($gain['categorie'] ?? 'interne') === 'externe') {
                $totalExterne += $totalFrais;
                continue;
            }

            $totalInterne += $totalFrais;
        }

        return view('admin/situation_gains', [
            'gains' => $gains,
            'totalInterne' => $totalInterne,
            'totalExterne' => $totalExterne,
        ]);
    }

    public function comptes()
    {
        $db = db_connect();

        $comptes = $db->table('compte_client')
                       ->orderBy('numero_telephone', 'ASC')
                       ->get()
                       ->getResultArray();

        return view('admin/situation_comptes', ['comptes' => $comptes]);
    }
}