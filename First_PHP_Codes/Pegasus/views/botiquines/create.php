<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h2>Crear Botiquín</h2>

<?php if (!empty($_SESSION['error'])) : ?>
	<div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
	<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form action="<?= BASE_URL ?>botiquines/create" method="post">
	<div class="form-group">
		<label for="nombre">Nombre del Botiquín</label>
		<input type="text" name="nombre" class="form-control" required>
	</div>

	<div class="form-group">
		<label for="id_planta">Planta</label>
		<select name="id_planta" class="form-control" required>
			<?php foreach ($plantas as $planta) : ?>
				<option value="<?= $planta['id'] ?>"><?= $planta['nombre'] ?> (<?= $planta['id'] ?>)</option>
			<?php endforeach; ?>
		</select>
	</div>

	<button type="submit" class="btn btn-success">Guardar</button>
	<a href="<?= BASE_URL ?>botiquines" class="btn btn-secondary">Cancelar</a>
</form>