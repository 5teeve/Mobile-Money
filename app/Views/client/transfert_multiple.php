<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>

<h1>Envoi multiple</h1>
<p style="margin-top:-.4rem;">Divisez un montant entre plusieurs numéros d'un même opérateur.</p>

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

<style>
    .numero-row { display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2); }
    .numero-row .input { flex: 1; }
    .numero-row .btn-remove-numero { padding: 0 .8rem; font-size: 1.2rem; line-height: 1; }
    #btn-add-numero { margin-top: var(--space-1); display: inline-flex; align-items: center; gap: .4rem; }
</style>

<section id="transfert-multiple-panel" class="op-panel transfert card card-pad">
    <div class="op-head">
        <span class="op-icon"><?= ui_icon('users') ?></span>
        <div>
            <h2>Envoi multiple</h2>
            <p>Le montant est réparti à parts égales entre les numéros ajoutés. Même opérateur uniquement.</p>
        </div>
    </div>

    <form method="post" action="<?= site_url('client/transfert-multiple') ?>" id="form-transfert-multiple">
        <?= csrf_field() ?>

        <div class="field">
            <label>Numéros destinataires</label>
            <div id="numeros-list">
                <div class="input-row numero-row">
                    <input type="text" name="numeros[]" class="input mono" placeholder="0331234567" required>
                    <button type="button" class="btn btn-ghost btn-remove-numero" aria-label="Retirer">&times;</button>
                </div>
                <div class="input-row numero-row">
                    <input type="text" name="numeros[]" class="input mono" placeholder="0331234568" required>
                    <button type="button" class="btn btn-ghost btn-remove-numero" aria-label="Retirer">&times;</button>
                </div>
            </div>
            <button type="button" id="btn-add-numero" class="btn btn-ghost">
                <?= ui_icon('plus') ?> Ajouter un numéro
            </button>
        </div>

        <div class="field">
            <label for="montant_multiple">Montant total à répartir</label>
            <div class="input-affix">
                <input type="number" step="0.01" min="0.01" id="montant_multiple" name="montant" class="input mono" placeholder="0" required>
                <span class="affix">Ar</span>
            </div>
            <p class="field-hint">Divisé à parts égales entre chaque numéro saisi.</p>
        </div>

        <div class="check-row">
            <input type="checkbox" id="inclure_frais_retrait_multiple" name="inclure_frais_retrait" value="1">
            <label for="inclure_frais_retrait_multiple">Inclure les frais de retrait des destinataires</label>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</section>

<a class="link-row" href="<?= site_url('client/operations') ?>">
    <span class="left">
        <?= ui_icon('out') ?>
        Retour aux opérations
    </span>
    <?= ui_icon('chevron') ?>
</a>

<script>
(function () {
    'use strict';

    var list = document.getElementById('numeros-list');
    var btnAdd = document.getElementById('btn-add-numero');
    if (!list || !btnAdd) return;

    function makeRow() {
        var row = document.createElement('div');
        row.className = 'input-row numero-row';
        row.innerHTML =
            '<input type="text" name="numeros[]" class="input mono" placeholder="03XXXXXXXX" required>' +
            '<button type="button" class="btn btn-ghost btn-remove-numero" aria-label="Retirer">&times;</button>';
        return row;
    }

    btnAdd.addEventListener('click', function () {
        list.appendChild(makeRow());
    });

    list.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-remove-numero');
        if (!btn) return;
        if (list.querySelectorAll('.numero-row').length <= 2) return; // min 2 numeros
        btn.closest('.numero-row').remove();
    });
})();
</script>

<?= $this->endSection() ?>