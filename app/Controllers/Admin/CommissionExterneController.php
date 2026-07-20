<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommissionExterneModel;
use App\Models\PrefixeModel;

class CommissionExterneController extends BaseController
{
    protected CommissionExterneModel $commissionModel;
    protected PrefixeModel $prefixeModel;

    public function __construct()
    {
        $this->commissionModel = new CommissionExterneModel();
        $this->prefixeModel = new PrefixeModel();
    }

    public function index()
    {
        return view('admin/commission_externe', [
            'commissions' => $this->commissionModel->getAvecPrefixe(),
            'prefixesExternes' => $this->prefixeModel->getExternes(),
        ]);
    }

    public function create()
    {
        $data = [
            'prefixe_id' => $this->request->getPost('prefixe_id'),
            'taux_pourcentage' => $this->request->getPost('taux_pourcentage'),
        ];

        if (!$this->commissionModel->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $this->commissionModel->errors());
        }

        return redirect()->to('/admin/commission-externe')->with('success', 'Commission ajoutée.');
    }

    public function edit($id)
    {
        $data = [
            'prefixe_id' => $this->request->getPost('prefixe_id'),
            'taux_pourcentage' => $this->request->getPost('taux_pourcentage'),
        ];

        if (!$this->commissionModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->commissionModel->errors());
        }

        return redirect()->to('/admin/commission-externe')->with('success', 'Commission modifiée.');
    }

    public function delete($id)
    {
        $this->commissionModel->delete($id);

        return redirect()->to('/admin/commission-externe')->with('success', 'Commission supprimée.');
    }
}