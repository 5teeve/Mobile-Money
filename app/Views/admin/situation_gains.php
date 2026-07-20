<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>Situation des gains</h1>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Jour</th>
            <th>Type</th>
            <th>Nb opérations</th>
            <th>Total frais</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gains as $gain): ?>
            <tr>
                <td><?= esc($gain['jour']) ?></td>
                <td><?= esc($gain['libelle_type']) ?></td>
                <td><?= esc($gain['nb_operations']) ?></td>
                <td><?= number_format((float) $gain['total_frais'], 0, ',', ' ') ?> Ar</td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection() ?>