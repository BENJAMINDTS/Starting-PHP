<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h2>Editar Almacén</h2>

<form action="<?= BASE_URL ?>almacenes/edit/<?= $almacen['id'] ?>" method="POST">
	<label for="id_planta">Planta:</label>
	<select name="id_planta" id="id_planta" required>
		<?php foreach ($plantas as $planta): ?>
			<option value="<?= $planta['id'] ?>" <?= $planta['id'] == $almacen['id_planta'] ? 'selected' : '' ?>>
				<?= htmlspecialchars($planta['nombre']) ?>
			</option>
		<?php endforeach; ?>
	</select>

	<label for="tipo">Tipo:</label>
	<select name="tipo" id="tipo" required>
		<option value="Almacenillo" <?= $almacen['tipo'] == 'Almacenillo' ? 'selected' : '' ?>>Almacenillo</option>
		<option value="General" <?= $almacen['tipo'] == 'General' ? 'selected' : '' ?>>General</option>
	</select>

	<button type="submit">Actualizar</button>
</form>