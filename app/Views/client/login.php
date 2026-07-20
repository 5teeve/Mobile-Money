<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Mobile Money</title>
</head>
<body>
    <h1>Connexion</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul style="color:red;">
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="<?= site_url('client/login') ?>">
        <?= csrf_field() ?>
        <label for="numero_telephone">Numero de telephone</label>
        <input type="text" id="numero_telephone" name="numero_telephone"
               value="<?= old('numero_telephone') ?>" placeholder="0331234567" required>
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
