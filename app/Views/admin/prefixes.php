<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Préfixes - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand navbar-dark bg-dark px-3">
    <a class="navbar-brand" href="<?= site_url('admin') ?>">Admin</a>
    <div class="navbar-nav">
        <a class="nav-link" href="<?= site_url('admin/prefixes') ?>">Préfixes</a>
        <a class="nav-link" href="<?= site_url('admin/types-operation') ?>">Types d'opération</a>
        <a class="nav-link" href="<?= site_url('admin/baremes') ?>">Barèmes</a>
        <a class="nav-link" href="<?= site_url('admin/situation/gains') ?>">Gains</a>
        <a class="nav-link" href="<?= site_url('admin/situation/comptes') ?>">Comptes clients</a>
        <a class="nav-link" href="<?= site_url('admin/commission-externe') ?>">Commission externe</a>
        <a class="nav-link" href="<?= site_url('admin/situation/a-envoyer') ?>">Montants à envoyer</a>
    </div>
</nav>
<div class="container mt-4">
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

<div class="btn-group mb-3">
    <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-sm <?= empty($categorieFiltre) ? 'btn-dark' : 'btn-outline-dark' ?>">Tous</a>
    <a href="<?= site_url('admin/prefixes') ?>?categorie=interne" class="btn btn-sm <?= $categorieFiltre === 'interne' ? 'btn-dark' : 'btn-outline-dark' ?>">Interne</a>
    <a href="<?= site_url('admin/prefixes') ?>?categorie=externe" class="btn btn-sm <?= $categorieFiltre === 'externe' ? 'btn-dark' : 'btn-outline-dark' ?>">Externe</a>
</div>

<form action="<?= site_url('admin/prefixes') ?>" method="post" class="row g-2 mb-4">
    <?= csrf_field() ?>
    <div class="col-auto">
        <input type="text" name="prefixe" class="form-control" placeholder="Ex: 033" maxlength="3" required>
    </div>
    <div class="col-auto">
        <select name="categorie" class="form-select" required>
            <option value="interne">Interne</option>
            <option value="externe">Externe</option>
        </select>
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
            <th>Catégorie</th>
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
                    <select form="form-prefixe-<?= $prefixe['id'] ?>" name="categorie" class="form-select">
                        <option value="interne" <?= $prefixe['categorie'] === 'interne' ? 'selected' : '' ?>>Interne</option>
                        <option value="externe" <?= $prefixe['categorie'] === 'externe' ? 'selected' : '' ?>>Externe</option>
                    </select>
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
</div>
</body>
</html>