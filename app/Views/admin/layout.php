<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Mobile Money</title>
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
        </div>
    </nav>
    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>
</body>
</html>