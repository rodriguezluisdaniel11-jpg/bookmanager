<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Titulo.php';

$db = (new Database())->getConnection();
$titulos = (new Titulo($db))->getAll();

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Títulos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= BASE_URL ?>index.php">Inicio</a></li>
        <li class="breadcrumb-item active">Títulos</li>
    </ol>

    <a href="crear.php" class="btn btn-primary mb-3">+ Nuevo título</a>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr><th>ID</th><th>Título</th><th>Tipo</th><th>Editorial</th><th>Precio</th><th>Publicación</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                <?php foreach ($titulos as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['id_titulo']) ?></td>
                        <td><?= htmlspecialchars($t['titulo']) ?></td>
                        <td><?= htmlspecialchars($t['tipo']) ?></td>
                        <td><?= htmlspecialchars($t['nombre_pub'] ?? '—') ?></td>
                        <td><?= $t['precio'] !== null ? '$' . number_format((float)$t['precio'], 2) : '—' ?></td>
                        <td><?= htmlspecialchars(substr($t['fecha_pub'], 0, 10)) ?></td>
                        <td>
                            <a href="editar.php?id=<?= urlencode($t['id_titulo']) ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= urlencode($t['id_titulo']) ?>" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($titulos)): ?>
                    <tr><td colspan="7" class="text-center">No hay títulos registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
