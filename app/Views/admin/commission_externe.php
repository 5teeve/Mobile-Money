<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commission externe - Admin</title>
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
<h1>Commission sur transferts externes</h1>
<p>Pourcentage prélevé sur chaque transfert vers un préfixe d'un autre opérateur.</p>

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

<form action="<?= site_url('admin/commission-externe') ?>" method="post" class="row g-2 mb-4">
    <?= csrf_field() ?>
    <div class="col-auto">
        <select name="prefixe_id" class="form-select" required>
            <?php foreach ($prefixesExternes as $prefixe): ?>
                <option value="<?= $prefixe['id'] ?>"><?= esc($prefixe['prefixe']) ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="col-auto">
        <div class="input-group">
            <input type="number" step="0.01" min="0" max="100" name="taux_pourcentage" class="form-control" placeholder="Taux %" required>
            <span class="input-group-text">%</span>
        </div>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Préfixe externe</th>
            <th>Taux</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($commissions as $commission): ?>
            <tr>
                <form id="form-commission-<?= $commission['id'] ?>" action="<?= site_url('admin/commission-externe/' . $commission['id']) ?>" method="post"><?= csrf_field() ?></form>
                <td>
                    <select form="form-commission-<?= $commission['id'] ?>" name="prefixe_id" class="form-select">
                        <?php foreach ($prefixesExternes as $prefixe): ?>
                            <option value="<?= $prefixe['id'] ?>" <?= $commission['prefixe_id'] == $prefixe['id'] ? 'selected' : '' ?>><?= esc($prefixe['prefixe']) ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
                <td>
                    <div class="input-group">
                        <input form="form-commission-<?= $commission['id'] ?>" type="number" step="0.01" min="0" max="100" name="taux_pourcentage" value="<?= esc($commission['taux_pourcentage']) ?>" class="form-control">
                        <span class="input-group-text">%</span>
                    </div>
                </td>
                <td class="text-nowrap">
                    <button form="form-commission-<?= $commission['id'] ?>" type="submit" class="btn btn-sm btn-secondary">Enregistrer</button>
                    <a href="<?= site_url('admin/commission-externe/' . $commission['id'] . '/delete') ?>"
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Supprimer cette commission ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>
</body>
</html>
