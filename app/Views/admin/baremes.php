<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>Barèmes de frais</h1>

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

<form action="<?= site_url('admin/baremes') ?>" method="post" class="row g-2 mb-4">
    <?= csrf_field() ?>
    <div class="col-auto">
        <select name="type_operation_id" class="form-select" required>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['id'] ?>"><?= esc($type['libelle']) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-auto">
        <input type="number" step="1" name="montant_min" class="form-control" placeholder="Montant min" required>
    </div>
    <div class="col-auto">
        <input type="number" step="1" name="montant_max" class="form-control" placeholder="Montant max" required>
    </div>
    <div class="col-auto">
        <input type="number" step="1" name="frais" class="form-control" placeholder="Frais" required>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Type</th>
            <th>Montant min</th>
            <th>Montant max</th>
            <th>Frais</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($baremes as $bareme): ?>
            <tr>
                <form id="form-bareme-<?= $bareme['id'] ?>" action="<?= site_url('admin/baremes/' . $bareme['id']) ?>" method="post"><?= csrf_field() ?></form>
                <td>
                    <select form="form-bareme-<?= $bareme['id'] ?>" name="type_operation_id" class="form-select">
                        <?php foreach ($types as $type): ?>
                            <option value="<?= $type['id'] ?>" <?= $bareme['type_operation_id'] == $type['id'] ? 'selected' : '' ?>><?= esc($type['libelle']) ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="montant_min" value="<?= esc($bareme['montant_min']) ?>" class="form-control">
                </td>
                <td>
                    <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="montant_max" value="<?= esc($bareme['montant_max']) ?>" class="form-control">
                </td>
                <td>
                    <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="frais" value="<?= esc($bareme['frais']) ?>" class="form-control">
                </td>
                <td class="text-nowrap">
                    <button form="form-bareme-<?= $bareme['id'] ?>" type="submit" class="btn btn-sm btn-secondary">Enregistrer</button>
                    <a href="<?= site_url('admin/baremes/' . $bareme['id'] . '/delete') ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer cette tranche ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection() ?>