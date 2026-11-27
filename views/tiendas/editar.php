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
    if ($tiendaModel->update($id, $_POST)) {
        header("Location: index.php");
        exit;
    }
    $errores = $tiendaModel->getErrores();
}
$valores = ($_SERVER['REQUEST_METHOD'] === 'POST') ? array_merge($_POST, ['id_tienda' => $id]) : $tienda;

require_once __DIR__ . '/../../includes/header.php';
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Editar tienda</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Tiendas</a></li>
        <li class="breadcrumb-item active">Editar</li>
    </ol>
    <div class="card"><div class="card-body">
        <?php require __DIR__ . '/_form.php'; ?>
    </div></div>
</div>
<?php require_once __DIR__ . '/../../includes/footer.php'; ?>
