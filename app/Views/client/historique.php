<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique - Mobile Money</title>
</head>
<body>
    <header>
        <h1>Historique</h1>
        <a href="<?= site_url('client/dashboard') ?>">Retour</a>
    </header>

    <main>
        <?php if (empty($operations)): ?>
            <p>Aucune operation pour le moment.</p>
        <?php else: ?>
            <table border="1" cellpadding="6">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Sens</th>
                        <th>Montant</th>
                        <th>Frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($operations as $op): ?>
                        <?php $sens = ((int) $op['compte_destination_id'] === $compteId) ? 'Entree' : 'Sortie'; ?>
                        <tr>
                            <td><?= esc($op['date_operation']) ?></td>
                            <td><?= esc($op['type_libelle']) ?></td>
                            <td><?= esc($sens) ?></td>
                            <td><?= number_format((float) $op['montant'], 2, ',', ' ') ?> Ar</td>
                            <td><?= number_format((float) $op['frais'], 2, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>
