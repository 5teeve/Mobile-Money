<!DOCTYPE html>
<html lang="fr">
<head>
<?= $this->include('partials/head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/client.css') ?>">
    <title><?= $title ?? 'Mobile Money' ?></title>
</head>
<body>
    <?php
        $route = uri_string();
        $pageTitle = 'Tableau de bord';
        switch ($route) {
            case 'client/operations':
                $pageTitle = 'Opérations';
                break;
            case 'client/historique':
                $pageTitle = 'Historique';
                break;
            default:
                $pageTitle = 'Tableau de bord';
        }
    ?>
    <div class="client-shell">
        <aside class="client-sidebar">
            <a class="brand" href="<?= site_url('client/dashboard') ?>">
                <span class="brand-mark"><?= ui_icon('bank') ?></span>
                <span>
                    Mobile Money
                    <small>Portail client</small>
                </span>
            </a>

            <nav class="nav-group">
                <div class="nav-group-label">Mon espace</div>
                <a href="<?= site_url('client/dashboard') ?>" class="<?= $route === 'client/dashboard' ? 'active' : '' ?>">
                    <?= ui_icon('bank') ?> Tableau de bord
                </a>
                <a href="<?= site_url('client/operations') ?>" class="<?= $route === 'client/operations' ? 'active' : '' ?>">
                    <?= ui_icon('wallet-down') ?> Opérations
                </a>
                <a href="<?= site_url('client/historique') ?>" class="<?= $route === 'client/historique' ? 'active' : '' ?>">
                    <?= ui_icon('history') ?> Historique
                </a>
            </nav>

            <div class="sidebar-footer">
                <a class="btn btn-ghost btn-block" href="<?= site_url('client/logout') ?>">
                    <?= ui_icon('logout') ?> Déconnexion
                </a>
            </div>
        </aside>

        <div class="client-main-panel">
            <header class="client-topbar">
                <div>
                    <div class="eyebrow">Espace client</div>
                    <h1><?= esc($pageTitle) ?></h1>
                </div>
                <div class="topbar-pill">Gestion simple et rapide</div>
            </header>
            <main class="client-content">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
