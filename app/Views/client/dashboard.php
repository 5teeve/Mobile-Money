<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord - Mobile Money</title>
</head>
<body>
    <header>
        <h1>Mobile Money</h1>
        <a href="<?= site_url('client/logout') ?>">Deconnexion</a>
    </header>

    <main>
        <p>Numero : <?= esc($compte['numero_telephone']) ?></p>
        <p>Solde : <?= number_format((float) $compte['solde'], 2, ',', ' ') ?> Ar</p>

        <nav>
            <a href="<?= site_url('client/operations') ?>">Operations</a>
            <a href="<?= site_url('client/historique') ?>">Historique</a>
        </nav>
    </main>
</body>
</html>
