<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>Situation des comptes clients</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Numéro de téléphone</th>
            <th>Solde</th>
            <th>Créé le</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($comptes as $compte): ?>
            <tr>
                <td><?= esc($compte['numero_telephone']) ?></td>
                <td><?= number_format((float) $compte['solde'], 0, ',', ' ') ?> Ar</td>
                <td><?= esc($compte['date_creation']) ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection() ?>
