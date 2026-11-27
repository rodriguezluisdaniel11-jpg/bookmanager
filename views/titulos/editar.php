<?php
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../models/Titulo.php';

$db = (new Database())->getConnection();
$tituloModel = new Titulo($db);
$publicadores = $tituloModel->getPublicadores();
$errores = [];

$id = (string)($_GET['id'] ?? '');
$titulo = $tituloModel->getById($id);
if (!$titulo) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($tituloModel->update($id, $_POST)) {
        header("Location: index.php");
        exit;
    }
    $errores = $tituloModel->getErrores();
}
$valores = ($_SERVER['REQUEST_METHOD'] === 'POST') ? array_merge($_POST, ['id_titulo' => $id]) : $titulo;

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar título</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Títulos</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="card"><div class="card-body">
        <?php require __DIR__ . '/_form.php'; ?>
    </div></div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
