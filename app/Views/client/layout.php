<!DOCTYPE html>
<html lang="fr">
<head>
<?= $this->include('partials/head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/client.css') ?>">
    <title><?= $title ?? 'Mobile Money' ?></title>
</head>
<body>
    <div class="client-shell">
        <header class="client-topbar">
            <a class="brand" href="<?= site_url('client/dashboard') ?>">
                <span class="brand-mark"><?= ui_icon('bank') ?></span>
                Mobile Money
            </a>
            <a class="btn-icon" href="<?= site_url('client/logout') ?>" title="Déconnexion" aria-label="Déconnexion">
                <?= ui_icon('logout') ?>
            </a>
        </header>
        <main class="client-main">
            <?= $this->renderSection('content') ?>
        </main>
    </div>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
