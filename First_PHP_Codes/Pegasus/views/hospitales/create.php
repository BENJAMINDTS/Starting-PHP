<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Crear Hospital</h1>
<form action="<?= BASE_URL ?>hospitales/create" method="POST">
	<label for="nombre">Nombre:</label>
	<input type="text" name="nombre" id="nombre" required>
	<br><br>
	<button type="submit">Guardar</button>
	<a href="<?= BASE_URL ?>hospitales">Cancelar</a>
</form>