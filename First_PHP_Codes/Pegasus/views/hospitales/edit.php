<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Editar Hospital</h1>
<form action="<?= BASE_URL ?>hospitales/edit/<?= $hospital['id'] ?>" method="POST">
	<label for="nombre">Nombre:</label>
	<input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($hospital['nombre']) ?>" required>
	<br><br>
	<button type="submit">Actualizar</button>
	<a href="<?= BASE_URL ?>hospitales">Cancelar</a>
</form>