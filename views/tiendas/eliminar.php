<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Tienda.php';

$db = (new Database())->getConnection();
$tiendaModel = new Tienda($db);
$errores = [];

$id = (string)($_GET['id'] ?? '');
$tienda = $tiendaModel->getById($id);
if (!$tienda) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tiendaModel->delete($id)) {
        header("Location: index.php");
        exit;
    }
    $errores = $tiendaModel->getErrores();
}

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Eliminar tienda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Tiendas</a></li>
        <li class="breadcrumb-item active">Eliminar</li>
    </ol>

    <?php foreach ($errores as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="card"><div class="card-body">
        <p>¿Seguro que deseas eliminar la tienda <strong><?= htmlspecialchars($tienda['nombre_tienda']) ?></strong>?</p>
        <form method="POST">
            <button class="btn btn-danger">Sí, eliminar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div></div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
