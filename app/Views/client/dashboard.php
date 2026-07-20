<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= ui_icon('check') ?>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= ui_icon('alert') ?>
        <span><?= esc(session()->getFlashdata('error')) ?></span>
    </div>
<?php endif; ?>

<div class="balance-card">
    <div class="row-top">
        <span class="balance-label">Solde disponible</span>
        <?= ui_icon('bank', 'icon') ?>
    </div>
    <div class="balance-figure">
        <?= number_format((float) $compte['solde'], 0, ',', ' ') ?><span class="cur">Ar</span>
    </div>
    <div class="balance-owner">
        <?= ui_icon('phone') ?>
        <?= esc($compte['numero_telephone']) ?>
        <?= ui_prefix_chip($compte['numero_telephone']) ?>
    </div>
</div>

<div class="action-grid">
    <a class="action-card depot" href="<?= site_url('client/operations') ?>?type=depot">
        <span class="action-icon"><?= ui_icon('wallet-down') ?></span>
        <div>
            <strong>Déposer</strong><br>
            <span class="desc">Ajouter des fonds</span>
        </div>
    </a>
    <a class="action-card retrait" href="<?= site_url('client/operations') ?>?type=retrait">
        <span class="action-icon"><?= ui_icon('wallet-up') ?></span>
        <div>
            <strong>Retirer</strong><br>
            <span class="desc">Sortir des fonds</span>
        </div>
    </a>
</div>

<a class="link-row" href="<?= site_url('client/historique') ?>">
    <span class="left">
        <?= ui_icon('history') ?>
        Historique des opérations
    </span>
    <?= ui_icon('chevron') ?>
</a>

<?= $this->endSection() ?>
