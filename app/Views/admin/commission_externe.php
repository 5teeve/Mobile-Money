<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Commission externe<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="panel">
    <p class="text-muted">Gérez les taux de commission appliqués aux transferts externes par préfixe.</p>
</div>

<?php if (session('success')): ?>
    <div class="alert alert-success"><?= ui_icon('check') ?><span><?= session('success') ?></span></div>
<?php endif ?>

<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <?= ui_icon('alert') ?>
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>

<div class="panel card card-pad">
    <div class="panel-title">
        <?= ui_icon('plus') ?><h2>Ajouter une commission</h2>
    </div>
    <form action="<?= site_url('admin/commission-externe') ?>" method="post" class="form-row">
        <?= csrf_field() ?>
        <div class="field">
            <label for="prefixe_id">Préfixe externe</label>
            <select id="prefixe_id" name="prefixe_id" class="select" required>
                <?php foreach ($prefixesExternes as $prefixe): ?>
                    <option value="<?= $prefixe['id'] ?>"><?= esc($prefixe['prefixe']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="field">
            <label for="taux_pourcentage">Taux de commission</label>
            <div class="input-group">
                <input id="taux_pourcentage" type="number" step="0.01" min="0" max="100" name="taux_pourcentage" class="input" placeholder="Taux %" required>
                <span class="input-group-text">%</span>
            </div>
        </div>
        <div class="field field-actions">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </div>
    </form>
</div>

<div class="panel card">
    <div class="table-wrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Préfixe externe</th>
                    <th>Taux</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commissions as $commission): ?>
                    <tr>
                        <form id="form-commission-<?= $commission['id'] ?>" action="<?= site_url('admin/commission-externe/' . $commission['id']) ?>" method="post"><?= csrf_field() ?></form>
                        <td>
                            <select form="form-commission-<?= $commission['id'] ?>" name="prefixe_id" class="select">
                                <?php foreach ($prefixesExternes as $prefixe): ?>
                                    <option value="<?= $prefixe['id'] ?>" <?= $commission['prefixe_id'] == $prefixe['id'] ? 'selected' : '' ?>><?= esc($prefixe['prefixe']) ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                        <td>
                            <div class="input-group">
                                <input form="form-commission-<?= $commission['id'] ?>" type="number" step="0.01" min="0" max="100" name="taux_pourcentage" value="<?= esc($commission['taux_pourcentage']) ?>" class="input">
                                <span class="input-group-text">%</span>
                            </div>
                        </td>
                        <td>
                            <div style="display:flex;gap:.5rem;justify-content:flex-end;">
                                <button form="form-commission-<?= $commission['id'] ?>" type="submit" class="btn btn-sm btn-ghost">Enregistrer</button>
                                <a href="<?= site_url('admin/commission-externe/' . $commission['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette commission ?')">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
