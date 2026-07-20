<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteClientModel;
use App\Models\PrefixeModel;

class AuthController extends BaseController
{
    public function showLogin()
    {
        return view('client/login');
    }

    public function login()
    {
        $rules = [
            'numero_telephone' => 'required|regex_match[/^0[0-9]{9}$/]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $numero       = $this->request->getPost('numero_telephone');
        $prefixeSaisi = substr($numero, 0, 3);

        $prefixeModel = new PrefixeModel();
        if (! $prefixeModel->estActif($prefixeSaisi)) {
            return redirect()->back()->withInput()->with('error', "Prefixe operateur non reconnu.");
        }

        // pas d'inscription prealable : creation auto du compte si inexistant
        $compteModel = new CompteClientModel();
        $compte      = $compteModel->findOrCreate($numero);

        session()->set([
            'compte_id'        => $compte['id'],
            'numero_telephone' => $compte['numero_telephone'],
            'isLoggedIn'       => true,
        ]);

        return redirect()->to('/client/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/client/login');
    }
}
