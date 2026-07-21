<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>

<h1>Épargne</h1>
<p style="margin-top:-.4rem;">Mettez de côté un pourcentage de chaque transfert que vous envoyez.</p>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= ui_icon('check') ?>
        <span><?= esc(session()->getFlashdata('success')) ?></span>
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
    .epargne-slider-row { display: flex; align-items: center; gap: var(--space-3); }
    .epargne-slider-row input[type="range"] { flex: 1; accent-color: var(--brand-600); }
    #epargne-taux-valeur { font-family: var(--font-mono); font-weight: 600; font-size: 1.1rem; min-width: 3.5em; text-align: right; }
</style>

<div class="balance-card">
    <div class="row-top">
        <span class="balance-label">Épargne accumulée</span>
        <?= ui_icon('coins', 'icon') ?>
    </div>
    <div class="balance-figure">
        <?= number_format((float) $compte['solde_epargne'], 0, ',', ' ') ?><span class="cur">Ar</span>
    </div>
    <div class="balance-owner">
        <?= ui_icon('sliders') ?>
        Taux actuel : <?= rtrim(rtrim(number_format((float) $compte['taux_epargne'], 2, '.', ''), '0'), '.') ?>% par transfert envoyé
    </div>
</div>

<section class="op-panel card card-pad">
    <div class="op-head">
        <span class="op-icon"><?= ui_icon('coins') ?></span>
        <div>
            <h2>Régler mon taux d'épargne</h2>
            <p>À chaque transfert envoyé (simple ou multiple), ce pourcentage du montant est prélevé sur votre solde et ajouté à votre épargne — en plus du montant envoyé et des frais.</p>
        </div>
    </div>

    <form method="post" action="<?= site_url('client/epargne') ?>">
        <?= csrf_field() ?>
        <div class="field">
            <label for="taux_epargne">Pourcentage à épargner</label>
            <div class="epargne-slider-row">
                <input
                    type="range"
                    id="taux_epargne_slider"
                    min="0"
                    max="100"
                    step="1"
                    value="<?= (int) round((float) $compte['taux_epargne']) ?>">
                <span id="epargne-taux-valeur"><?= (int) round((float) $compte['taux_epargne']) ?>%</span>
            </div>
            <input
                type="number"
                id="taux_epargne"
                name="taux_epargne"
                class="input mono"
                min="0"
                max="100"
                step="0.01"
                value="<?= esc((string) $compte['taux_epargne']) ?>"
                style="max-width:9rem;margin-top:var(--space-2);"
                required>
            <p class="field-hint">0% désactive l'épargne automatique. Modifiable à tout moment.</p>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</section>

<script>
    (function () {
        var slider = document.getElementById('taux_epargne_slider');
        var number = document.getElementById('taux_epargne');
        var live = document.getElementById('epargne-taux-valeur');
        if (!slider || !number || !live) return;

        slider.addEventListener('input', function () {
            number.value = slider.value;
            live.textContent = slider.value + '%';
        });
        number.addEventListener('input', function () {
            var v = Math.min(100, Math.max(0, parseFloat(number.value) || 0));
            slider.value = v;
            live.textContent = v + '%';
        });
    })();
</script>

<?= $this->endSection() ?>
