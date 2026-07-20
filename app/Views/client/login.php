<!DOCTYPE html>
<html lang="fr">

<head>
    <?= $this->include('partials/head') ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/client.css') ?>">
    <title>Connexion - Mobile Money</title>
</head>

<body>
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-mark"><?= ui_icon('phone') ?></div>
            <h1>Se connecter</h1>
            <p class="auth-sub">Entrez votre numéro de téléphone pour accéder à votre compte.</p>

            <div class="card card-pad">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= ui_icon('alert') ?>
                        <span><?= esc(session()->getFlashdata('error')) ?></span>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?= ui_icon('alert') ?>
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                <li><?= esc($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('client/login') ?>">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label for="numero_telephone">Numéro de téléphone</label>
                        <input type="tel" inputmode="numeric" id="numero_telephone" name="numero_telephone"
                            class="input mono" placeholder="033 12 345 67" value="<?= old('numero_telephone') ?>"
                            autocomplete="tel" autofocus required>
                        <div id="phone-live" class="phone-live" data-state="unknown"></div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </form>
                <a href="<?= site_url() . '/admin/prefixes' ?>" class="btn btn-ghost btn-block" style="margin-top: var(--space-3);">Admin</a>
            </div>
        </div>
    </div>

    <script type="application/json" id="active-prefixes"><?= json_encode($prefixesActifs ?? []) ?></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>