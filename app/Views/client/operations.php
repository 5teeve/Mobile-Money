<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>

<h1>Opérations</h1>
<p style="margin-top:-.4rem;">Déposez ou retirez des fonds sur votre compte.</p>

<div class="balance-strip">
    <span>Solde actuel</span>
    <span class="val"><?= number_format((float) $compte['solde'], 0, ',', ' ') ?> Ar</span>
</div>

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

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <?= ui_icon('alert') ?>
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                <li><?= esc($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<section id="depot-panel" class="op-panel depot card card-pad">
    <div class="op-head">
        <span class="op-icon"><?= ui_icon('wallet-down') ?></span>
        <div>
            <h2>Dépôt</h2>
            <p>Ajoutez des fonds à votre compte Mobile Money.</p>
        </div>
    </div>
    <form method="post" action="<?= site_url('client/operations/depot') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="montant_depot">Montant</label>
            <div class="input-affix">
                <input type="number" step="0.01" min="0.01" id="montant_depot" name="montant" class="input mono" placeholder="0" required>
                <span class="affix">Ar</span>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Déposer</button>
    </form>
</section>

<section id="retrait-panel" class="op-panel retrait card card-pad">
    <div class="op-head">
        <span class="op-icon"><?= ui_icon('wallet-up') ?></span>
        <div>
            <h2>Retrait</h2>
            <p>Retirez des fonds de votre compte Mobile Money.</p>
        </div>
    </div>
    <form method="post" action="<?= site_url('client/operations/retrait') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="montant_retrait">Montant</label>
            <div class="input-affix">
                <input type="number" step="0.01" min="0.01" id="montant_retrait" name="montant" class="input mono" placeholder="0" required>
                <span class="affix">Ar</span>
            </div>
            <p class="field-hint">Des frais peuvent s'appliquer selon le montant retiré.</p>
        </div>
        <button type="submit" class="btn btn-amber">Retirer</button>
    </form>
</section>

<a class="link-row" href="<?= site_url('client/historique') ?>">
    <span class="left">
        <?= ui_icon('history') ?>
        Voir l'historique
    </span>
    <?= ui_icon('chevron') ?>
</a>

<?= $this->endSection() ?>
