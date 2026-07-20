<?= $this->extend('admin/layout') ?>

<?= $this->section('title') ?>Situation des gains<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="panel">
    <p class="text-muted">Suivi des gains internes et externes avec une vue synthétique des montants collectés.</p>
</div>

<div class="admin-stats-grid">
    <div class="card admin-stats-card">
        <div class="eyebrow">Gains interne</div>
        <div class="amount"><?= number_format($totalInterne, 0, ',', ' ') ?> Ar</div>
    </div>
    <div class="card admin-stats-card">
        <div class="eyebrow">Gains externe</div>
        <div class="amount"><?= number_format($totalExterne, 0, ',', ' ') ?> Ar</div>
    </div>
</div>

<div class="panel card">
    <div class="panel-title">
        <h2>Historique des gains</h2>
    </div>
    <div class="table-wrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Type</th>
                    <th>Catégorie</th>
                    <th>Nb opérations</th>
                    <th>Total frais</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gains as $gain): ?>
                    <tr>
                        <td><?= esc($gain['jour']) ?></td>
                        <td><?= esc($gain['libelle_type']) ?></td>
                        <td>
                            <?php if ($gain['categorie'] === 'externe'): ?>
                                <span class="badge badge-warning">Externe</span>
                            <?php else: ?>
                                <span class="badge badge-neutral">Interne</span>
                            <?php endif ?>
                        </td>
                        <td><?= esc($gain['nb_operations']) ?></td>
                        <td><?= number_format((float) $gain['total_frais'], 0, ',', ' ') ?> Ar</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
