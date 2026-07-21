<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Promotions<?= $this->endSection() ?>

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
    <div class="panel-title"><?= ui_icon('plus') ?><h2>Ajouter une promotion</h2></div>
    <form action="<?= site_url('admin/promotions') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="field" style="flex:2 1 220px;">
                <label for="libelle">Libellé</label>
                <input type="text" id="libelle" name="libelle" class="input" placeholder="Ex: Promo lancement" required>
            </div>
            <div class="field">
                <label for="pourcentage">Réduction (%)</label>
                <input type="number" step="0.01" min="0" max="100" id="pourcentage" name="pourcentage" class="input mono" placeholder="20" required>
            </div>
            <div class="field">
                <div class="check-row" style="margin-top:2.2rem;">
                    <input type="checkbox" id="actif" name="actif" value="1" checked>
                    <label for="actif">Active</label>
                </div>
            </div>
            <div class="field field-actions">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="panel card">
    <?php if (empty($promotions)): ?>
        <div class="empty-state">
            <?= ui_icon('coins', 'icon icon-lg') ?>
            <h3>Aucune promotion</h3>
            <p>Ajoutez une réduction en % applicable sur les frais de transfert interne.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Libellé</th>
                        <th>Réduction</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($promotions as $promo): ?>
                        <tr>
                            <form id="form-promo-<?= $promo['id'] ?>" action="<?= site_url('admin/promotions/' . $promo['id']) ?>" method="post"><?= csrf_field() ?></form>
                            <td>
                                <input form="form-promo-<?= $promo['id'] ?>" type="text" name="libelle" value="<?= esc($promo['libelle']) ?>" class="input">
                            </td>
                            <td>
                                <input form="form-promo-<?= $promo['id'] ?>" type="number" step="0.01" min="0" max="100" name="pourcentage" value="<?= esc($promo['pourcentage']) ?>" class="input mono" style="max-width:7rem;">
                                %
                            </td>
                            <td>
                                <select form="form-promo-<?= $promo['id'] ?>" name="actif" class="select" style="max-width:8rem;">
                                    <option value="1" <?= $promo['actif'] ? 'selected' : '' ?>>Active</option>
                                    <option value="0" <?= !$promo['actif'] ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <button form="form-promo-<?= $promo['id'] ?>" type="submit" class="btn btn-sm btn-ghost">Enregistrer</button>
                                    <a href="<?= site_url('admin/promotions/' . $promo['id'] . '/delete') ?>"
                                       class="btn-icon danger"
                                       title="Supprimer"
                                       aria-label="Supprimer cette promotion"
                                       onclick="return confirm('Supprimer cette promotion ?')"><?= ui_icon('trash') ?></a>
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
