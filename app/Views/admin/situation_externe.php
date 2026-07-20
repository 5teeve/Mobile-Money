<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Montants à envoyer<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="panel card card-pad">
    <div class="panel-title">
        <?= ui_icon('sliders') ?><h2>Montants à envoyer</h2>
    </div>
    <p class="text-muted">Total des transferts sortants vers chaque préfixe externe, à reverser à l'opérateur concerné.</p>
</div>

<div class="panel card">
    <div class="table-wrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Préfixe externe</th>
                    <th>Nb transferts</th>
                    <th>Montant total à envoyer</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($totaux)): ?>
                    <tr>
                        <td colspan="3" class="text-center">Aucun transfert externe pour le moment.</td>
                    </tr>
                <?php endif ?>
                <?php foreach ($totaux as $ligne): ?>
                    <tr>
                        <td><?= esc($ligne['prefixe']) ?></td>
                        <td><?= esc($ligne['nb_operations']) ?></td>
                        <td><?= number_format((float) $ligne['total_montant'], 0, ',', ' ') ?> Ar</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
