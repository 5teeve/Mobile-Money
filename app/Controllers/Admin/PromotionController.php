<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromotionModel;

class PromotionController extends BaseController
{
    protected PromotionModel $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    public function index()
    {
        return view('admin/promotions', [
            'promotions' => $this->promotionModel->findAll(),
        ]);
    }

    public function create()
    {
        $data = [
            'libelle'     => $this->request->getPost('libelle'),
            'pourcentage' => $this->request->getPost('pourcentage'),
            'actif'       => $this->request->getPost('actif') ? 1 : 0,
        ];

        if (! $this->promotionModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->promotionModel->errors());
        }

        return redirect()->to('/admin/promotions')->with('success', 'Promotion ajoutée.');
    }

    public function edit($id)
    {
        $data = [
            'libelle'     => $this->request->getPost('libelle'),
            'pourcentage' => $this->request->getPost('pourcentage'),
            'actif'       => $this->request->getPost('actif') ? 1 : 0,
        ];

        if (! $this->promotionModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->promotionModel->errors());
        }

        return redirect()->to('/admin/promotions')->with('success', 'Promotion modifiée.');
    }

    public function delete($id)
    {
        $this->promotionModel->delete($id);

        return redirect()->to('/admin/promotions')->with('success', 'Promotion supprimée.');
    }
}
