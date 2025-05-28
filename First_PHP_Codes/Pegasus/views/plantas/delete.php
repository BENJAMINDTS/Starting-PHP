<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Eliminar Planta</h1>

<p>¿Estás seguro de que deseas eliminar la planta <strong><?= htmlspecialchars($planta['nombre']) ?></strong> asociada al hospital <strong><?= htmlspecialchars($hospital['nombre']) ?></strong>?</p>

<form action="<?= BASE_URL ?>plantas/delete/<?= $planta['id'] ?>" method="POST">
	<button type="submit">Sí, eliminar</button>
	<a href="<?= BASE_URL ?>plantas">Cancelar</a>
</form>