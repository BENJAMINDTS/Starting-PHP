<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Perfil de Usuario</h1>

<p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->nombre) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($usuario->email) ?></p>
<p><strong>Rol:</strong> <?= htmlspecialchars($usuario->rol) ?></p>

<p><strong>Hospitales:</strong>
<?php if (!empty($hospitales) && is_array($hospitales)): ?>
  <ul>
    <?php foreach ($hospitales as $hospital): ?>
      <li><?= htmlspecialchars($hospital['nombre']) ?></li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  N/A
<?php endif; ?>
</p>

<p><strong>Plantas:</strong>
<?php if (!empty($plantas) && is_array($plantas)): ?>
  <ul>
    <?php foreach ($plantas as $planta): ?>
      <li><?= htmlspecialchars($planta['nombre']) ?></li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  N/A
<?php endif; ?>
</p>

<p><strong>Botiquines:</strong>
<?php if (!empty($botiquines) && is_array($botiquines)): ?>
  <ul>
    <?php foreach ($botiquines as $botiquin): ?>
      <li><?= htmlspecialchars($botiquin['nombre']) ?></li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  N/A
<?php endif; ?>
</p>

<a href="<?= BASE_URL ?>usuarios/edit/<?= $usuario->id ?>">Editar perfil</a> |
<a href="<?= BASE_URL ?>usuarios">Volver al listado</a>
