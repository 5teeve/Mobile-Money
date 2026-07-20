<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Operations - Mobile Money</title>
</head>
<body>
    <header>
        <h1>Operations</h1>
        <a href="<?= site_url('client/dashboard') ?>">Retour</a>
    </header>

    <main>
        <p>Solde actuel : <?= number_format((float) $compte['solde'], 2, ',', ' ') ?> Ar</p>

        <?php if (session()->getFlashdata('success')): ?>
            <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
        <?php endif; ?>

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

        <section>
            <h2>Depot</h2>
            <form method="post" action="<?= site_url('client/operations/depot') ?>">
                <?= csrf_field() ?>
                <label for="montant_depot">Montant</label>
                <input type="number" step="0.01" min="0.01" id="montant_depot" name="montant" required>
                <button type="submit">Deposer</button>
            </form>
        </section>

        <section>
            <h2>Retrait</h2>
            <form method="post" action="<?= site_url('client/operations/retrait') ?>">
                <?= csrf_field() ?>
                <label for="montant_retrait">Montant</label>
                <input type="number" step="0.01" min="0.01" id="montant_retrait" name="montant" required>
                <button type="submit">Retirer</button>
            </form>
        </section>

        <nav>
            <a href="<?= site_url('client/historique') ?>">Historique</a>
        </nav>
    </main>
</body>
</html>
