<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Préfixes opérateur<?= $this->endSection() ?>

<?= $this->section('content') ?>

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
    <div class="panel-title"><?= ui_icon('plus') ?><h2>Ajouter un préfixe</h2></div>
    <form action="<?= site_url('admin/prefixes') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="field">
                <label for="prefixe">Préfixe</label>
                <input type="text" id="prefixe" name="prefixe" class="input mono" placeholder="Ex: 033" maxlength="3" required>
            </div>
            <div class="field field-actions">
                <div class="check-row" style="margin-bottom:.65rem;">
                    <input type="checkbox" id="actif" name="actif" value="1" checked>
                    <label for="actif">Actif</label>
                </div>
            </div>
            <div class="field field-actions">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="panel card">
    <?php if (empty($prefixes)): ?>
        <div class="empty-state">
            <?= ui_icon('sliders', 'icon icon-lg') ?>
            <h3>Aucun préfixe enregistré</h3>
            <p>Ajoutez un préfixe opérateur ci-dessus pour commencer à router les numéros clients.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Préfixe</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prefixes as $prefixe): ?>
                        <tr>
                            <form id="form-prefixe-<?= $prefixe['id'] ?>" action="<?= site_url('admin/prefixes/' . $prefixe['id']) ?>" method="post"><?= csrf_field() ?></form>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem;">
                                    <?= ui_prefix_chip($prefixe['prefixe']) ?>
                                    <input form="form-prefixe-<?= $prefixe['id'] ?>" type="text" name="prefixe" value="<?= esc($prefixe['prefixe']) ?>" maxlength="3" class="input mono" style="max-width:6rem;">
                                </div>
                            </td>
                            <td>
                                <select form="form-prefixe-<?= $prefixe['id'] ?>" name="actif" class="select" style="max-width:9rem;">
                                    <option value="1" <?= $prefixe['actif'] ? 'selected' : '' ?>>Actif</option>
                                    <option value="0" <?= !$prefixe['actif'] ? 'selected' : '' ?>>Inactif</option>
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <button form="form-prefixe-<?= $prefixe['id'] ?>" type="submit" class="btn btn-sm btn-ghost">Enregistrer</button>
                                    <a href="<?= site_url('admin/prefixes/' . $prefixe['id'] . '/delete') ?>"
                                       class="btn-icon danger"
                                       title="Supprimer"
                                       aria-label="Supprimer ce préfixe"
                                       onclick="return confirm('Supprimer ce préfixe ?')"><?= ui_icon('trash') ?></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
