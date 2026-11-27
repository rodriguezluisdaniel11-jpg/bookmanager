<?php
$v = fn($k) => htmlspecialchars($valores[$k] ?? '');
$esEdicion = isset($tienda);
?>
<?php foreach ($errores as $e): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<form method="POST">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label">ID tienda (máx. 4)</label>
            <input type="text" name="id_tienda" maxlength="4" class="form-control"
                   value="<?= $v('id_tienda') ?>" <?= $esEdicion ? 'readonly' : '' ?>>
        </div>
        <div class="col-md-9 mb-3">
            <label class="form-label">Nombre de la tienda</label>
            <input type="text" name="nombre_tienda" maxlength="40" class="form-control" value="<?= $v('nombre_tienda') ?>">
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direcc_tienda" maxlength="40" class="form-control" value="<?= $v('direcc_tienda') ?>">
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Ciudad</label>
            <input type="text" name="ciudad" maxlength="15" class="form-control" value="<?= $v('ciudad') ?>">
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Estado</label>
            <input type="text" name="estado" maxlength="2" class="form-control" value="<?= $v('estado') ?>">
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">País</label>
            <input type="text" name="pais" maxlength="3" class="form-control" value="<?= $v('pais') ?>">
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Cód. postal</label>
            <input type="text" name="cod_postal" maxlength="5" class="form-control" value="<?= $v('cod_postal') ?>">
        </div>
        <div class="col-md-2 mb-3">
            <label class="form-label">Términos</label>
            <input type="text" name="terminos" maxlength="6" class="form-control" value="<?= $v('terminos') ?>">
        </div>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
