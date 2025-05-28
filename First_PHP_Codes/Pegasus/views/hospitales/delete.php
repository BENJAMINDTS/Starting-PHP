<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Eliminar Hospital</h1>
<p>¿Está seguro que desea eliminar el hospital <strong><?= htmlspecialchars($hospital['nombre']) ?></strong>?</p>
<form action="<?= BASE_URL ?>hospitales/destroy" method="POST">
	<input type="hidden" name="id" value="<?= htmlspecialchars($hospital['id']) ?>">
	<button type="submit">Sí, eliminar</button>
	<a href="<?= BASE_URL ?>hospitales">Cancelar</a>
</form>