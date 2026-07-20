<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Situation des gains - Admin</title>
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
<h1>Situation des gains</h1>

<div class="row mb-4">
    <div class="col-auto">
        <div class="card" style="min-width:220px;">
            <div class="card-body">
                <div class="text-muted small">Gains interne</div>
                <div class="fs-4"><?= number_format($totalInterne, 0, ',', ' ') ?> Ar</div>
            </div>
        </div>
    </div>
    <div class="col-auto">
        <div class="card" style="min-width:220px;">
            <div class="card-body">
                <div class="text-muted small">Gains externe</div>
                <div class="fs-4"><?= number_format($totalExterne, 0, ',', ' ') ?> Ar</div>
            </div>
        </div>
    </div>
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Jour</th>
            <th>Type</th>
            <th>Catégorie</th>
            <th>Nb opérations</th>
            <th>Total frais</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gains as $gain): ?>
            <tr>
                <td><?= esc($gain['jour']) ?></td>
                <td><?= esc($gain['libelle_type']) ?></td>
                <td><?= $gain['categorie'] === 'externe' ? '<span class="badge bg-warning text-dark">Externe</span>' : '<span class="badge bg-secondary">Interne</span>' ?></td>
                <td><?= esc($gain['nb_operations']) ?></td>
                <td><?= number_format((float) $gain['total_frais'], 0, ',', ' ') ?> Ar</td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>
</body>
</html>