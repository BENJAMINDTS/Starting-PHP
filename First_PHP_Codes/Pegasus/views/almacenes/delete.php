<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h2>Eliminar Almacén</h2>

<p>¿Estás seguro de que deseas eliminar este almacén?</p>

<form action="<?= BASE_URL ?>almacenes/delete/<?= $almacen['id'] ?>" method="POST">
	<button type="submit">Sí, eliminar</button>
	<a href="<?= BASE_URL ?>almacenes">Cancelar</a>
</form>