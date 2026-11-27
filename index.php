<?php
require_once __DIR__ . '/config/app.php';

$totalTiendas = $totalTitulos = null;
try {
    $db = (new Database())->getConnection();
    $totalTiendas = (new Tienda($db))->count();
    $totalTitulos = (new Titulo($db))->count();
} catch (Throwable $ex) {
    $errorBD = 'Aún no hay conexión con la base de datos. Los contadores aparecerán cuando se importe dblibreria.';
}

require_once __DIR__ . '/includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Inicio</h1>
    <ol class="breadcrumb mb-4"><li class="breadcrumb-item active">Panel principal</li></ol>

    <?php if (isset($errorBD)): ?>
        <div class="alert alert-warning"><?= e($errorBD) ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="fs-2 fw-bold"><?= $totalTiendas ?? '—' ?></div>
                    Tiendas registradas
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= BASE_URL ?>views/tiendas/index.php">Administrar tiendas</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="fs-2 fw-bold"><?= $totalTitulos ?? '—' ?></div>
                    Títulos registrados
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?= BASE_URL ?>views/titulos/index.php">Administrar títulos</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Bienvenido a BookManager</h5>
            Sistema para gestionar el inventario de libros y la red de tiendas de distribución.
            Usa el menú lateral para navegar.
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
