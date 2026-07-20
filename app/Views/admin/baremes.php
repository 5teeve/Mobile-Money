<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Barèmes de frais<?= $this->endSection() ?>

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
    <div class="panel-title"><?= ui_icon('plus') ?><h2>Ajouter une tranche</h2></div>
    <form action="<?= site_url('admin/baremes') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="field" style="flex:1.4 1 200px;">
                <label for="type_operation_id">Type</label>
                <select id="type_operation_id" name="type_operation_id" class="select" required>
                    <?php foreach ($types as $type): ?>
                        <option value="<?= $type['id'] ?>"><?= esc($type['libelle']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="field">
                <label for="montant_min">Montant min</label>
                <input type="number" step="1" id="montant_min" name="montant_min" class="input mono" placeholder="0" required>
            </div>
            <div class="field">
                <label for="montant_max">Montant max</label>
                <input type="number" step="1" id="montant_max" name="montant_max" class="input mono" placeholder="0" required>
            </div>
            <div class="field">
                <label for="frais">Frais</label>
                <input type="number" step="1" id="frais" name="frais" class="input mono" placeholder="0" required>
            </div>
            <div class="field field-actions">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="panel card">
    <?php if (empty($baremes)): ?>
        <div class="empty-state">
            <?= ui_icon('sliders', 'icon icon-lg') ?>
            <h3>Aucun barème défini</h3>
            <p>Ajoutez une tranche ci-dessus pour définir les frais appliqués selon le montant de l'opération.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th class="num">Montant min</th>
                        <th class="num">Montant max</th>
                        <th class="num">Frais</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($baremes as $bareme): ?>
                        <tr>
                            <form id="form-bareme-<?= $bareme['id'] ?>" action="<?= site_url('admin/baremes/' . $bareme['id']) ?>" method="post"><?= csrf_field() ?></form>
                            <td>
                                <select form="form-bareme-<?= $bareme['id'] ?>" name="type_operation_id" class="select" style="max-width:12rem;">
                                    <?php foreach ($types as $type): ?>
                                        <option value="<?= $type['id'] ?>" <?= $bareme['type_operation_id'] == $type['id'] ? 'selected' : '' ?>><?= esc($type['libelle']) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                            <td class="num">
                                <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="montant_min" value="<?= esc($bareme['montant_min']) ?>" class="input mono" style="text-align:right;">
                            </td>
                            <td class="num">
                                <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="montant_max" value="<?= esc($bareme['montant_max']) ?>" class="input mono" style="text-align:right;">
                            </td>
                            <td class="num">
                                <input form="form-bareme-<?= $bareme['id'] ?>" type="number" name="frais" value="<?= esc($bareme['frais']) ?>" class="input mono" style="text-align:right;">
                            </td>
                            <td class="text-nowrap">
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <button form="form-bareme-<?= $bareme['id'] ?>" type="submit" class="btn btn-sm btn-ghost">Enregistrer</button>
                                    <a href="<?= site_url('admin/baremes/' . $bareme['id'] . '/delete') ?>"
                                       class="btn-icon danger"
                                       title="Supprimer"
                                       aria-label="Supprimer cette tranche"
                                       onclick="return confirm('Supprimer cette tranche ?')"><?= ui_icon('trash') ?></a>
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
