<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Models\CompteClientModel;

class EpargneController extends BaseController
{
    public function index()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        return view('client/epargne', ['compte' => $compte]);
    }

    public function modifier()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        $rules = [
            'taux_epargne' => 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[100]',
        ];

        $messages = [
            'taux_epargne' => [
                'greater_than_equal_to' => 'Le pourcentage doit être entre 0 et 100.',
                'less_than_equal_to' => 'Le pourcentage doit être entre 0 et 100.',
            ],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $taux = (float) $this->request->getPost('taux_epargne');

        (new CompteClientModel())->definirTauxEpargne((int) $compte['id'], $taux);

        return redirect()->to('/client/epargne')
            ->with('success', "Épargne automatique réglée sur {$taux}% de chaque transfert.");
    }

    private function compteConnecte(): ?array
    {
        if (! session()->get('isLoggedIn')) {
            return null;
        }

        return (new CompteClientModel())->find(session()->get('compte_id'));
    }
}
