<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Situation des gains<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$nbOperations = array_sum(array_column($gains, 'nb_operations'));
$totalFrais   = array_sum(array_column($gains, 'total_frais'));
?>

<div class="kpi-row">
    <div class="kpi-card">
        <div class="kpi-label">Opérations facturées</div>
        <div class="kpi-value"><?= number_format($nbOperations, 0, ',', ' ') ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Total des frais collectés</div>
        <div class="kpi-value"><?= number_format($totalFrais, 0, ',', ' ') ?><small>Ar</small></div>
    </div>
</div>

<div class="panel card">
    <?php if (empty($gains)): ?>
        <div class="empty-state">
            <?= ui_icon('coins', 'icon icon-lg') ?>
            <h3>Aucun gain enregistré</h3>
            <p>Les frais perçus sur les opérations clients apparaîtront ici, groupés par jour et par type.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jour</th>
                        <th>Type</th>
                        <th class="num">Nb opérations</th>
                        <th class="num">Total frais</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($gains as $gain): ?>
                        <tr>
                            <td class="mono"><?= esc($gain['jour']) ?></td>
                            <td><span class="badge badge-neutral"><?= esc($gain['libelle_type']) ?></span></td>
                            <td class="num"><?= number_format((float) $gain['nb_operations'], 0, ',', ' ') ?></td>
                            <td class="num"><?= number_format((float) $gain['total_frais'], 0, ',', ' ') ?> Ar</td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
