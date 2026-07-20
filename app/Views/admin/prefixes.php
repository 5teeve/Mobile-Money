<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>Préfixes opérateur</h1>

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

<form action="<?= site_url('admin/prefixes') ?>" method="post" class="row g-2 mb-4">
    <?= csrf_field() ?>
    <div class="col-auto">
        <input type="text" name="prefixe" class="form-control" placeholder="Ex: 033" maxlength="3" required>
    </div>
    <div class="col-auto form-check mt-2">
        <input type="checkbox" name="actif" value="1" class="form-check-input" id="actif" checked>
        <label class="form-check-label" for="actif">Actif</label>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Préfixe</th>
            <th>Statut</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($prefixes as $prefixe): ?>
            <tr>
                <form id="form-prefixe-<?= $prefixe['id'] ?>" action="<?= site_url('admin/prefixes/' . $prefixe['id']) ?>" method="post"><?= csrf_field() ?></form>
                <td>
                    <input form="form-prefixe-<?= $prefixe['id'] ?>" type="text" name="prefixe" value="<?= esc($prefixe['prefixe']) ?>" maxlength="3" class="form-control">
                </td>
                <td>
                    <select form="form-prefixe-<?= $prefixe['id'] ?>" name="actif" class="form-select">
                        <option value="1" <?= $prefixe['actif'] ? 'selected' : '' ?>>Actif</option>
                        <option value="0" <?= !$prefixe['actif'] ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </td>
                <td class="text-nowrap">
                    <button form="form-prefixe-<?= $prefixe['id'] ?>" type="submit" class="btn btn-sm btn-secondary">Enregistrer</button>
                    <a href="<?= site_url('admin/prefixes/' . $prefixe['id'] . '/delete') ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer ce préfixe ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection() ?>