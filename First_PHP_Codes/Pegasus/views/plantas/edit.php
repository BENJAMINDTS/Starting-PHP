<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Editar Planta</h1>

<?php if (isset($error)): ?>
	<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="<?= BASE_URL ?>plantas/edit/<?= $planta['id'] ?>" method="POST">
	<label for="nombre">Nombre de la planta:</label>
	<input
		type="text"
		id="nombre"
		name="nombre"
		required
		value="<?= isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : htmlspecialchars($planta['nombre']) ?>">
	<br><br>

	<label for="id_hospital">Hospital:</label>
	<select name="id_hospital" id="id_hospital" required>
		<option value="">-- Seleccione un hospital --</option>
		<?php foreach ($hospitales as $hospital): ?>
			<option
				value="<?= $hospital['id'] ?>"
				<?= (isset($_POST['id_hospital']) && $_POST['id_hospital'] == $hospital['id'])
					? 'selected'
					: ($planta['id_hospital'] == $hospital['id'] ? 'selected' : '')
				?>>
				<?= htmlspecialchars($hospital['nombre']) ?>
			</option>
		<?php endforeach; ?>
	</select>
	<br><br>

	<button type="submit">Actualizar</button>
	<a href="<?= BASE_URL ?>plantas">Cancelar</a>
</form>