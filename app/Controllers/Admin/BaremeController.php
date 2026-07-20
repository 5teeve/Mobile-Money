<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BaremeModel;
use App\Models\TypeOperationModel;

class BaremeController extends BaseController
{
    protected BaremeModel $baremeModel;
    protected TypeOperationModel $typeOperationModel;

    public function __construct()
    {
        $this->baremeModel = new BaremeModel();
        $this->typeOperationModel = new TypeOperationModel();
    }

    public function index()
    {
        return view('admin/baremes', [
            'baremes' => $this->baremeModel->findAll(),
            'types' => $this->typeOperationModel->findAll(),
        ]);
    }

    public function create()
    {
        $data = [
            'type_operation_id' => $this->request->getPost('type_operation_id'),
            'montant_min' => $this->request->getPost('montant_min'),
            'montant_max' => $this->request->getPost('montant_max'),
            'frais' => $this->request->getPost('frais'),
        ];

        if (!$this->baremeModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->baremeModel->errors());
        }

        return redirect()->to('/admin/baremes')->with('success', 'Tranche ajoutée.');
    }

    public function edit($id)
    {
        $data = [
            'type_operation_id' => $this->request->getPost('type_operation_id'),
            'montant_min' => $this->request->getPost('montant_min'),
            'montant_max' => $this->request->getPost('montant_max'),
            'frais' => $this->request->getPost('frais'),
        ];

        if (!$this->baremeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->baremeModel->errors());
        }

        return redirect()->to('/admin/baremes')->with('success', 'Tranche modifiée.');
    }

    public function delete($id)
    {
        $this->baremeModel->delete($id);

        return redirect()->to('/admin/baremes')->with('success', 'Tranche supprimée.');
    }
}