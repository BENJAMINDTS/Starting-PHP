<?php
require_once __DIR__ . '/../config/config.php';
// views/relaciones/usuario_almacen.php

$almacenesRelacionados = array_filter($relaciones, fn($r) => $r['tipo_entidad'] === 'almacen');
$idsRelacionados = array_column($almacenesRelacionados, 'entidad_id');
?>

<h2>Relaciones Usuario - Almacenes</h2>
<p>Usuario: <?= htmlspecialchars($usuario['nombre'] ?? $usuario->nombre) ?></p>

<form method="post" action="<?= BASE_URL ?>relacion/update/<?= $usuario['id'] ?? $usuario->id ?>">
    <input type="hidden" name="tipo_entidad" value="almacen" />
    <ul>
        <?php foreach ($almacenes as $almacen): ?>
            <li>
                <label>
                    <input type="checkbox" name="almacen[]" value="<?= $almacen['id'] ?>"
                        <?= in_array($almacen['id'], $idsRelacionados) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($almacen['nombre']) ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Guardar Relaciones Almacenes</button>
</form>
