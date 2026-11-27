<?php
$v = fn($k) => htmlspecialchars($valores[$k] ?? '');
$esEdicion = isset($titulo) && is_array($titulo);
$fechaValor = substr($valores['fecha_pub'] ?? date('Y-m-d'), 0, 10);
$contratoValor = (string)($valores['contrato'] ?? '1');
?>
<?php foreach ($errores as $e): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div>
<?php endforeach; ?>

<form method="POST">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label">ID título (máx. 6)</label>
            <input type="text" name="id_titulo" maxlength="6" class="form-control"
                   value="<?= $v('id_titulo') ?>" <?= $esEdicion ? 'readonly' : '' ?>>
        </div>
        <div class="col-md-9 mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" maxlength="60" class="form-control" value="<?= $v('titulo') ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" maxlength="15" class="form-control" value="<?= $v('tipo') ?>">
        </div>
        <div class="col-md-8 mb-3">
            <label class="form-label">Editorial</label>
            <select name="id_pub" class="form-select">
                <option value="">-- Selecciona una editorial --</option>
                <?php foreach ($publicadores as $p): ?>
                    <option value="<?= htmlspecialchars($p['id_pub']) ?>"
                        <?= ((string)($valores['id_pub'] ?? '') === (string)$p['id_pub']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre_pub']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" min="0" name="precio" class="form-control" value="<?= $v('precio') ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Fecha de publicación</label>
            <input type="date" name="fecha_pub" class="form-control" value="<?= htmlspecialchars($fechaValor) ?>">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Contrato</label>
            <select name="contrato" class="form-select">
                <option value="1" <?= $contratoValor === '1' ? 'selected' : '' ?>>Sí</option>
                <option value="0" <?= $contratoValor === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Notas</label>
        <textarea name="notas" maxlength="255" class="form-control" rows="3"><?= $v('notas') ?></textarea>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>
