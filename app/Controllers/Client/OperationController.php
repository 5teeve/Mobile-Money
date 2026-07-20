<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Exceptions\OperationException;
use App\Models\CompteClientModel;
use App\Services\OperationService;

class OperationController extends BaseController
{
    private function compteConnecte(): ?array
    {
        if (! session()->get('isLoggedIn')) {
            return null;
        }

        return (new CompteClientModel())->find(session()->get('compte_id'));
    }

    public function depot()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        if (! $this->validate(['montant' => 'required|numeric|greater_than[0]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $montant = (float) $this->request->getPost('montant');

        try {
            $resultat = (new OperationService())->depot($compte, $montant);
        } catch (OperationException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to('/client/dashboard')
            ->with('success', "Depot de {$resultat['montant']} Ar effectue.");
    }

    public function retrait()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        if (! $this->validate(['montant' => 'required|numeric|greater_than[0]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $montant = (float) $this->request->getPost('montant');

        try {
            $resultat = (new OperationService())->retrait($compte, $montant);
        } catch (OperationException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to('/client/dashboard')
            ->with('success', "Retrait de {$resultat['montant']} Ar effectue (frais: {$resultat['frais']} Ar).");
    }
}
