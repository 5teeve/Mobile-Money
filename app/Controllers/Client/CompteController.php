<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteClientModel;

class CompteController extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/client/login');
        }

        $compteModel = new CompteClientModel();
        $compte      = $compteModel->find(session()->get('compte_id'));

        if (! $compte) {
            session()->destroy();

            return redirect()->to('/client/login');
        }

        return view('client/dashboard', ['compte' => $compte]);
    }
}
