<?php
require_once __DIR__ . '/../config/config.php';
// views/relaciones/usuario_hospital.php

// Variables disponibles:
// $usuario (objeto o array)
// $hospitales (lista de todos los hospitales)
// $relaciones (relaciones actuales del usuario, filtrar las de tipo 'hospital')

$hospitalesRelacionados = array_filter($relaciones, fn($r) => $r['tipo_entidad'] === 'hospital');
$idsRelacionados = array_column($hospitalesRelacionados, 'entidad_id');
?>

<h2>Relaciones Usuario - Hospitales</h2>
<p>Usuario: <?= htmlspecialchars($usuario['nombre'] ?? $usuario->nombre) ?></p>

<form method="post" action="<?= BASE_URL ?>relacion/update/<?= $usuario['id'] ?? $usuario->id ?>">
    <input type="hidden" name="tipo_entidad" value="hospital" />
    <ul>
        <?php foreach ($hospitales as $hospital): ?>
            <li>
                <label>
                    <input type="checkbox" name="hospital[]" value="<?= $hospital['id'] ?>"
                        <?= in_array($hospital['id'], $idsRelacionados) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($hospital['nombre']) ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Guardar Relaciones Hospitales</button>
</form>
