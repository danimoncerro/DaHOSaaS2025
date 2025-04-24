<?php require_once view_path('admin/layouts/header'); ?>

<div class="container mt-5">
    <h2 class="mb-4">Module disponibile</h2>

    <div class="row">
        <?php foreach ($modules as $module): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($module['name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($module['description']) ?></p>
                        <p class="card-text"><strong><?= number_format($module['price_per_month'], 2) ?> RON / lună</strong></p>
                        <button class="btn btn-primary">Activează</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once view_path('admin/layouts/footer'); ?>
