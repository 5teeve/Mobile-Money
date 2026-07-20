<?php
// renderSection() consomme son buffer : on le capture une seule fois ici
// pour pouvoir l'afficher à la fois dans <title> et dans le <h1>.
ob_start();
$this->renderSection('title');
$pageTitle = trim(ob_get_clean()) ?: 'Admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<?= $this->include('partials/head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
    <title><?= $pageTitle ?> - Mobile Money</title>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="brand" href="<?= site_url('admin') ?>">
                <span class="brand-mark"><?= ui_icon('bank') ?></span>
                Mobile Money
                <small>Back-office</small>
            </a>

            <nav class="nav-group">
                <div class="nav-group-label">Paramétrage</div>
                <a href="<?= site_url('admin/prefixes') ?>" class="<?= uri_string() === 'admin/prefixes' ? 'active' : '' ?>">
                    <?= ui_icon('sliders') ?> Préfixes
                </a>
                <a href="<?= site_url('admin/types-operation') ?>" class="<?= uri_string() === 'admin/types-operation' ? 'active' : '' ?>">
                    <?= ui_icon('coins') ?> Types d'opération
                </a>
                <a href="<?= site_url('admin/baremes') ?>" class="<?= uri_string() === 'admin/baremes' ? 'active' : '' ?>">
                    <?= ui_icon('sliders') ?> Barèmes
                </a>
            </nav>

            <nav class="nav-group">
                <div class="nav-group-label">Suivi</div>
                <a href="<?= site_url('admin/situation/gains') ?>" class="<?= uri_string() === 'admin/situation/gains' ? 'active' : '' ?>">
                    <?= ui_icon('coins') ?> Gains
                </a>
                <a href="<?= site_url('admin/situation/comptes') ?>" class="<?= uri_string() === 'admin/situation/comptes' ? 'active' : '' ?>">
                    <?= ui_icon('users') ?> Comptes clients
                </a>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div>
                    <div class="eyebrow">Administration</div>
                    <h1><?= $pageTitle ?></h1>
                </div>
            </header>
            <div class="admin-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
