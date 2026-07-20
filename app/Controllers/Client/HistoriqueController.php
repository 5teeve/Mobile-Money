<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\HistoriqueModel;

class HistoriqueController extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/client/login');
        }

        $compteId   = (int) session()->get('compte_id');
        $operations = (new HistoriqueModel())->findByCompte($compteId);

        return view('client/historique', [
            'operations' => $operations,
            'compteId'   => $compteId,
        ]);
    }
}
