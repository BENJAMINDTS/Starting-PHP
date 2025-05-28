<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h1>Crear Planta</h1>

<?php if (isset($error)): ?>
	<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="<?= BASE_URL ?>plantas/create" method="POST">
	<label for="nombre">Nombre de la planta:</label>
	<input type="text" name="nombre" id="nombre" required>
	<br><br>

	<label for="id_hospital">Hospital:</label>
	<select name="id_hospital" id="id_hospital" required>
		<option value="">-- Seleccione un hospital --</option>
		<?php foreach ($hospitales as $hospital): ?>
			<option value="<?= $hospital['id'] ?>"><?= htmlspecialchars($hospital['nombre']) ?></option>
		<?php endforeach; ?>
	</select>
	<br><br>

	<button type="submit">Guardar</button>
	<a href="<?= BASE_URL ?>plantas">Cancelar</a>
</form>