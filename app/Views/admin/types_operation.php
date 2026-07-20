<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>Types d'opération</h1>

<?php if (session('success')): ?>
    <div class="alert alert-success"><?= session('success') ?></div>
<?php endif ?>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<form action="<?= site_url('admin/types-operation') ?>" method="post" class="row g-2 mb-4">
    <?= csrf_field() ?>
    <div class="col-auto">
        <select name="code" class="form-select" required>
            <option value="DEPOT">DEPOT</option>
            <option value="RETRAIT">RETRAIT</option>
            <option value="TRANSFERT">TRANSFERT</option>
        </select>
    </div>
    <div class="col-auto">
        <input type="text" name="libelle" class="form-control" placeholder="Libellé" required>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Code</th>
            <th>Libellé</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($types as $type): ?>
            <tr>
                <form id="form-type-<?= $type['id'] ?>" action="<?= site_url('admin/types-operation/' . $type['id']) ?>" method="post"><?= csrf_field() ?></form>
                <td>
                    <select form="form-type-<?= $type['id'] ?>" name="code" class="form-select">
                        <?php foreach (['DEPOT', 'RETRAIT', 'TRANSFERT'] as $code): ?>
                            <option value="<?= $code ?>" <?= $type['code'] === $code ? 'selected' : '' ?>><?= $code ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <input form="form-type-<?= $type['id'] ?>" type="text" name="libelle" value="<?= esc($type['libelle']) ?>" class="form-control">
                </td>
                <td class="text-nowrap">
                    <button form="form-type-<?= $type['id'] ?>" type="submit" class="btn btn-sm btn-secondary">Enregistrer</button>
                    <a href="<?= site_url('admin/types-operation/' . $type['id'] . '/delete') ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer ce type ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection() ?>