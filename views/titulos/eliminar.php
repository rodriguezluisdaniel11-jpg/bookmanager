<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Titulo.php';

$db = (new Database())->getConnection();
$tituloModel = new Titulo($db);
$errores = [];

$id = (string)($_GET['id'] ?? '');
$titulo = $tituloModel->getById($id);
if (!$titulo) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tituloModel->delete($id)) {
        header("Location: index.php");
        exit;
    }
    $errores = $tituloModel->getErrores();
}

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Eliminar título</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Títulos</a></li>
        <li class="breadcrumb-item active">Eliminar</li>
    </ol>

    <?php foreach ($errores as $e): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
    <?php endforeach; ?>

    <div class="card"><div class="card-body">
        <p>¿Seguro que deseas eliminar el título <strong><?= htmlspecialchars($titulo['titulo']) ?></strong>?</p>
        <form method="POST">
            <button class="btn btn-danger">Sí, eliminar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div></div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
