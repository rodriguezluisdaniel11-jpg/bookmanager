<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Titulo.php';

$db = (new Database())->getConnection();
$tituloModel = new Titulo($db);
$publicadores = $tituloModel->getPublicadores();
$errores = [];
$valores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tituloModel->create($_POST)) {
        header("Location: index.php");
        exit;
    }
    $errores = $tituloModel->getErrores();
    $valores = $_POST;
}

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Nuevo título</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Títulos</a></li>
        <li class="breadcrumb-item active">Crear</li>
    </ol>
    <div class="card"><div class="card-body">
        <?php require __DIR__ . '/_form.php'; ?>
    </div></div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
