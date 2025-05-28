<?php
require_once __DIR__ . '/../config/config.php';
// views/relaciones/usuario_botiquin.php

$botiquinesRelacionados = array_filter($relaciones, fn($r) => $r['tipo_entidad'] === 'botiquin');
$idsRelacionados = array_column($botiquinesRelacionados, 'entidad_id');
?>

<h2>Relaciones Usuario - Botiquines</h2>
<p>Usuario: <?= htmlspecialchars($usuario['nombre'] ?? $usuario->nombre) ?></p>

<form method="post" action="<?= BASE_URL ?>relacion/update/<?= $usuario['id'] ?? $usuario->id ?>">
    <input type="hidden" name="tipo_entidad" value="botiquin" />
    <ul>
        <?php foreach ($botiquines as $botiquin): ?>
            <li>
                <label>
                    <input type="checkbox" name="botiquin[]" value="<?= $botiquin['id'] ?>"
                        <?= in_array($botiquin['id'], $idsRelacionados) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($botiquin['nombre']) ?>
                </label>
            </li>
        <?php endforeach; ?>
    </ul>
    <button type="submit">Guardar Relaciones Botiquines</button>
</form>
