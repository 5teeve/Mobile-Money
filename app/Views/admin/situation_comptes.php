<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Situation des comptes clients<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$nbComptes = count($comptes);
$soldeTotal = array_sum(array_column($comptes, 'solde'));
$soldeMoyen = $nbComptes > 0 ? $soldeTotal / $nbComptes : 0;
?>

<div class="kpi-row">
    <div class="kpi-card">
        <div class="kpi-label">Comptes actifs</div>
        <div class="kpi-value"><?= number_format($nbComptes, 0, ',', ' ') ?></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Solde total</div>
        <div class="kpi-value"><?= number_format($soldeTotal, 0, ',', ' ') ?><small>Ar</small></div>
    </div>
    <div class="kpi-card">
        <div class="kpi-label">Solde moyen</div>
        <div class="kpi-value"><?= number_format($soldeMoyen, 0, ',', ' ') ?><small>Ar</small></div>
    </div>
</div>

<div class="panel card">
    <?php if (empty($comptes)): ?>
        <div class="empty-state">
            <?= ui_icon('users', 'icon icon-lg') ?>
            <h3>Aucun compte client</h3>
            <p>Les comptes sont créés automatiquement à la première connexion d'un client.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Numéro de téléphone</th>
                        <th class="num">Solde</th>
                        <th>Créé le</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comptes as $compte): ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <?= ui_prefix_chip($compte['numero_telephone']) ?>
                                    <span class="mono"><?= esc($compte['numero_telephone']) ?></span>
                                </div>
                            </td>
                            <td class="num"><?= number_format((float) $compte['solde'], 0, ',', ' ') ?> Ar</td>
                            <td class="mono"><?= esc($compte['date_creation']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
