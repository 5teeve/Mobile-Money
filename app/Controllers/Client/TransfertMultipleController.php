<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use App\Exceptions\OperationException;
use App\Models\CompteClientModel;
use App\Services\TransfertMultipleService;

class TransfertMultipleController extends BaseController
{
    public function index()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        return view('client/transfert_multiple', ['compte' => $compte]);
    }

    public function envoyer()
    {
        $compte = $this->compteConnecte();
        if (! $compte) {
            return redirect()->to('/client/login');
        }

        $rules = [
            'numeros'   => 'required',
            'numeros.*' => 'regex_match[/^0[0-9]{9}$/]',
            'montant'   => 'required|numeric|greater_than[0]',
        ];

        $messages = [
            'numeros' => ['required' => 'Ajoutez au moins un numero destinataire.'],
            'numeros.*' => ['regex_match' => 'Un des numeros saisis est invalide.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $numeros = array_map('trim', (array) $this->request->getPost('numeros'));
        $numeros = array_values(array_filter($numeros, static fn ($n) => $n !== ''));
        $montant = (float) $this->request->getPost('montant');
        $inclureFraisRetrait = (bool) $this->request->getPost('inclure_frais_retrait');

        try {
            $resultat = (new TransfertMultipleService())->envoyer($compte, $numeros, $montant, $inclureFraisRetrait);
        } catch (OperationException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $nb = count($resultat['details']);

        $message = "Envoi multiple de {$resultat['montant_total']} Ar reparti entre {$nb} numeros effectue (frais totaux: {$resultat['frais_total']} Ar).";
        if ($resultat['epargne_total'] > 0) {
            $message .= " {$resultat['epargne_total']} Ar mis de cote en epargne.";
        }

        return redirect()->to('/client/dashboard')->with('success', $message);
    }

    private function compteConnecte(): ?array
    {
        if (! session()->get('isLoggedIn')) {
            return null;
        }

        return (new CompteClientModel())->find(session()->get('compte_id'));
    }
}