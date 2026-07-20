<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TypeOperationModel;

class TypeOperationController extends BaseController
{
    protected TypeOperationModel $typeOperationModel;

    public function __construct()
    {
        $this->typeOperationModel = new TypeOperationModel();
    }

    public function index()
    {
        return view('admin/types_operation', [
            'types' => $this->typeOperationModel->findAll(),
        ]);
    }

    public function create()
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'libelle' => $this->request->getPost('libelle'),
        ];

        if (!$this->typeOperationModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->typeOperationModel->errors());
        }

        return redirect()->to('/admin/types-operation')->with('success', 'Type ajouté.');
    }

    public function edit($id)
    {
        $data = [
            'code' => $this->request->getPost('code'),
            'libelle' => $this->request->getPost('libelle'),
        ];

        if (!$this->typeOperationModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->typeOperationModel->errors());
        }

        return redirect()->to('/admin/types-operation')->with('success', 'Type modifié.');
    }

    public function delete($id)
    {
        $this->typeOperationModel->delete($id);

        return redirect()->to('/admin/types-operation')->with('success', 'Type supprimé.');
    }
}