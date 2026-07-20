<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Types d'opération<?= $this->endSection() ?>

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
    <div class="panel-title"><?= ui_icon('plus') ?><h2>Ajouter un type d'opération</h2></div>
    <form action="<?= site_url('admin/types-operation') ?>" method="post">
        <?= csrf_field() ?>
        <div class="form-row">
            <div class="field">
                <label for="code">Code</label>
                <select id="code" name="code" class="select" required>
                    <option value="DEPOT">DEPOT</option>
                    <option value="RETRAIT">RETRAIT</option>
                    <option value="TRANSFERT">TRANSFERT</option>
                </select>
            </div>
            <div class="field" style="flex:2 1 220px;">
                <label for="libelle">Libellé</label>
                <input type="text" id="libelle" name="libelle" class="input" placeholder="Ex: Dépôt en espèces" required>
            </div>
            <div class="field field-actions">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<div class="panel card">
    <?php if (empty($types)): ?>
        <div class="empty-state">
            <?= ui_icon('coins', 'icon icon-lg') ?>
            <h3>Aucun type d'opération</h3>
            <p>Ajoutez un type ci-dessus (dépôt, retrait ou transfert) pour pouvoir lui associer des barèmes.</p>
        </div>
    <?php else: ?>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Libellé</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($types as $type): ?>
                        <tr>
                            <form id="form-type-<?= $type['id'] ?>" action="<?= site_url('admin/types-operation/' . $type['id']) ?>" method="post"><?= csrf_field() ?></form>
                            <td>
                                <select form="form-type-<?= $type['id'] ?>" name="code" class="select" style="max-width:11rem;">
                                    <?php foreach (['DEPOT', 'RETRAIT', 'TRANSFERT'] as $code): ?>
                                        <option value="<?= $code ?>" <?= $type['code'] === $code ? 'selected' : '' ?>><?= $code ?></option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                            <td>
                                <input form="form-type-<?= $type['id'] ?>" type="text" name="libelle" value="<?= esc($type['libelle']) ?>" class="input">
                            </td>
                            <td class="text-nowrap">
                                <div style="display:flex;gap:.4rem;justify-content:flex-end;">
                                    <button form="form-type-<?= $type['id'] ?>" type="submit" class="btn btn-sm btn-ghost">Enregistrer</button>
                                    <a href="<?= site_url('admin/types-operation/' . $type['id'] . '/delete') ?>"
                                       class="btn-icon danger"
                                       title="Supprimer"
                                       aria-label="Supprimer ce type"
                                       onclick="return confirm('Supprimer ce type ?')"><?= ui_icon('trash') ?></a>
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
