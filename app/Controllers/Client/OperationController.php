<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Exceptions\OperationException;
use App\Models\CompteClientModel;
use App\Services\OperationService;

class OperationController extends BaseController
{
    public function index()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        return view('client/operations', ['compte' => $compte]);
    }

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

    public function transfert()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        $rules = [
            'numero_destination' => 'required|regex_match[/^0[0-9]{9}$/]',
            'montant'            => 'required|numeric|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $numeroDestination   = $this->request->getPost('numero_destination');
        $montant             = (float) $this->request->getPost('montant');
        $inclureFraisRetrait = (bool) $this->request->getPost('inclure_frais_retrait');

        try {
            $resultat = (new OperationService())->transfert($compte, $numeroDestination, $montant, $inclureFraisRetrait);
        } catch (OperationException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to('/client/dashboard')
            ->with('success', "Transfert de {$resultat['montant']} Ar vers {$numeroDestination} effectue (frais: {$resultat['frais']} Ar).");
    }
}
