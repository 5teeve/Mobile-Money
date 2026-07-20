<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PrefixeModel;

class PrefixeController extends BaseController
{
    protected PrefixeModel $prefixeModel;

    public function __construct()
    {
        $this->prefixeModel = new PrefixeModel();
    }

    public function index()
    {
        $categorie = $this->request->getGet('categorie');
        $query = $this->prefixeModel;

        if (in_array($categorie, ['interne', 'externe'], true)) {
            $query = $query->where('categorie', $categorie);
        }

        return view('admin/prefixes', [
            'prefixes' => $query->findAll(),
            'categorieFiltre' => $categorie,
        ]);
    }

    public function create()
    {
        $data = [
            'prefixe' => $this->request->getPost('prefixe'),
            'actif' => $this->request->getPost('actif') ? 1 : 0,
            'categorie' => $this->request->getPost('categorie'),
        ];

        if (!$this->prefixeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->prefixeModel->errors());
        }

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe ajouté.');
    }

    public function edit($id)
    {
        $data = [
            'prefixe' => $this->request->getPost('prefixe'),
            'actif' => $this->request->getPost('actif') ? 1 : 0,
            'categorie' => $this->request->getPost('categorie'),
        ];

        if (!$this->prefixeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->prefixeModel->errors());
        }

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe modifié.');
    }

    public function delete($id)
    {
        $this->prefixeModel->delete($id);

        return redirect()->to('/admin/prefixes')->with('success', 'Préfixe supprimé.');
    }
}