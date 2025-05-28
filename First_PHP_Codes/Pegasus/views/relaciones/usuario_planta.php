<?php
require_once __DIR__ . '/../config/config.php';
// views/relaciones/usuario_planta.php

$plantasRelacionadas = array_filter($relaciones, fn($r) => $r['tipo_entidad'] === 'planta');
$idsRelacionados = array_column($plantasRelacionadas, 'entidad_id');
?>

<h2>Relaciones Usuario - Plantas</h2>
<p>Usuario: <?= htmlspecialchars($usuario['nombre'] ?? $usuario->nombre) ?></p>

<form method="post" action="<?= BASE_URL ?>relacion/update/<?= $usuario['id'] ?? $usuario->id ?>">
    <input type="hidden" name="tipo_entidad" value="planta" />
    <ul>
        <?php foreach ($plantas as $planta): ?>
            <li>
                <label>
                    <input type="checkbox" name="planta[]" value="<?= $planta['id'] ?>"
                        <?= in_array($planta['id'], $idsRelacionados) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($planta['nombre']) ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Guardar Relaciones Plantas</button>
</form>
