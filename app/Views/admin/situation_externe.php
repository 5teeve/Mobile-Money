<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Montants à envoyer - Admin</title>
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
<h1>Montants à envoyer aux opérateurs externes</h1>
<p>Total des transferts sortants vers chaque préfixe externe, à reverser à l'opérateur concerné.</p>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Préfixe externe</th>
            <th>Nb transferts</th>
            <th>Montant total à envoyer</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($totaux)): ?>
            <tr><td colspan="3" class="text-center text-muted">Aucun transfert externe pour le moment.</td></tr>
        <?php endif ?>
        <?php foreach ($totaux as $ligne): ?>
            <tr>
                <td><?= esc($ligne['prefixe']) ?></td>
                <td><?= esc($ligne['nb_operations']) ?></td>
                <td><?= number_format((float) $ligne['total_montant'], 0, ',', ' ') ?> Ar</td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
</div>
</body>
</html>
