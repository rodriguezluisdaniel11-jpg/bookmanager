<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Tienda.php';

$db = (new Database())->getConnection();
$tiendas = (new Tienda($db))->getAll();

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Tiendas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
        <li class="breadcrumb-item active">Tiendas</li>
    </ol>

    <a href="crear.php" class="btn btn-primary mb-3">+ Nueva tienda</a>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>ID</th><th>Nombre</th><th>Dirección</th><th>Ciudad</th><th>Estado</th><th>País</th><th>Términos</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                <?php foreach ($tiendas as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['id_tienda']) ?></td>
                        <td><?= htmlspecialchars($t['nombre_tienda']) ?></td>
                        <td><?= htmlspecialchars($t['direcc_tienda']) ?></td>
                        <td><?= htmlspecialchars($t['ciudad']) ?></td>
                        <td><?= htmlspecialchars($t['estado']) ?></td>
                        <td><?= htmlspecialchars($t['pais']) ?></td>
                        <td><?= htmlspecialchars($t['terminos']) ?></td>
                        <td>
                            <a href="editar.php?id=<?= urlencode($t['id_tienda']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= urlencode($t['id_tienda']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($tiendas)): ?>
                    <tr><td colspan="8" class="text-center">No hay tiendas registradas.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
