<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h2>Crear Almacén</h2>

<form action="<?= BASE_URL ?>almacenes/create" method="POST">
	<label for="id_planta">Planta:</label>
	<select name="id_planta" id="id_planta" required>
		<?php foreach ($plantas as $planta): ?>
			<option value="<?= $planta['id'] ?>"><?= htmlspecialchars($planta['nombre']) ?></option>
		<?php endforeach; ?>
	</select>

	<label for="tipo">Tipo:</label>
	<select name="tipo" id="tipo" required>
		<option value="Almacenillo">Almacenillo</option>
		<option value="General">General</option>
	</select>

	<button type="submit">Crear</button>
</form>