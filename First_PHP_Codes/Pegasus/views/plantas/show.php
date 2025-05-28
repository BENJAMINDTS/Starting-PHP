<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Detalle de Planta</h1>

<?php if (!$planta): ?>
	<p>Planta no encontrada.</p>
	<a href="<?= BASE_URL ?>plantas">Volver al listado</a>
<?php else: ?>
	<p><strong>ID:</strong> <?= htmlspecialchars($planta['id']) ?></p>
	<p><strong>Nombre:</strong> <?= htmlspecialchars($planta['nombre']) ?></p>
	<p><strong>Hospital asociado:</strong> <?= htmlspecialchars($hospital['nombre']) ?></p>

	<a href="<?= BASE_URL ?>plantas/edit/<?= $planta['id'] ?>">Editar</a> |
	<a href="<?= BASE_URL ?>plantas/delete/<?= $planta['id'] ?>" onclick="return confirm('¿Seguro que quieres eliminar esta planta?')">Eliminar</a> |
	<a href="<?= BASE_URL ?>plantas">Volver al listado</a>
<?php endif; ?>