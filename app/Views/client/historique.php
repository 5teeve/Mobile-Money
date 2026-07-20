<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>

<h1>Historique</h1>
<p style="margin-top:-.4rem;">L'ensemble de vos dépôts et retraits.</p>

<?php if (empty($operations)): ?>
    <div class="card">
        <div class="empty-state">
            <span class="icon-lg" style="display:inline-flex;"><?= ui_icon('history', 'icon icon-lg') ?></span>
            <h3>Aucune opération pour le moment</h3>
            <p>Vos dépôts et retraits apparaîtront ici dès que vous en effectuerez un.</p>
            <a class="btn btn-primary" href="<?= site_url('client/operations') ?>">Faire une opération</a>
        </div>
    </div>
<?php else: ?>
    <div class="card table-wrap">
        <table class="table hist-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Sens</th>
                    <th class="num">Montant</th>
                    <th class="num">Frais</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operations as $op): ?>
                    <?php $entree = ((int) $op['compte_destination_id'] === $compteId); ?>
                    <tr>
                        <td data-label="Date" class="mono"><?= esc($op['date_operation']) ?></td>
                        <td data-label="Type"><?= esc($op['type_libelle']) ?></td>
                        <td data-label="Sens">
                            <?php if ($entree): ?>
                                <span class="sens-badge in"><?= ui_icon('in') ?> Entrée</span>
                            <?php else: ?>
                                <span class="sens-badge out"><?= ui_icon('out') ?> Sortie</span>
                            <?php endif; ?>
                        </td>
                        <td data-label="Montant" class="num"><?= number_format((float) $op['montant'], 0, ',', ' ') ?> Ar</td>
                        <td data-label="Frais" class="num"><?= number_format((float) $op['frais'], 0, ',', ' ') ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
