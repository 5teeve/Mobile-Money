<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class SituationExterneController extends BaseController
{
    public function index()
    {
        $db = db_connect();

        $totaux = $db->table('operation o')
                      ->select('p.prefixe AS prefixe, SUM(o.montant) AS total_montant, COUNT(o.id) AS nb_operations')
                      ->join('type_operation t', 't.id = o.type_operation_id')
                      ->join('compte_client cd', 'cd.id = o.compte_destination_id')
                      ->join('prefixe p', "p.prefixe = substr(cd.numero_telephone, 1, 3)")
                      ->where('t.code', 'TRANSFERT')
                      ->where('p.categorie', 'externe')
                      ->groupBy('p.prefixe')
                      ->orderBy('total_montant', 'DESC')
                      ->get()
                      ->getResultArray();

        return view('admin/situation_externe', ['totaux' => $totaux]);
    }
}
