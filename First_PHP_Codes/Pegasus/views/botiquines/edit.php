<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h2>Editar Botiquín</h2>

<form action="<?= BASE_URL ?>botiquines/edit/<?= $botiquin['id'] ?>" method="post">
	<div class="form-group">
		<label for="nombre">Nombre del Botiquín</label>
		<input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($botiquin['nombre']) ?>" required>
	</div>

	<div class="form-group">
		<label for="id_planta">Planta</label>
		<select name="id_planta" class="form-control" required>
			<?php foreach ($plantas as $planta) : ?>
				<option value="<?= $planta['id'] ?>" <?= $planta['id'] == $botiquin['id_planta'] ? 'selected' : '' ?>>
					<?= $planta['nombre'] ?> (<?= $planta['id'] ?>)
				</option>
			<?php endforeach; ?>
		</select>
	</div>

	<button type="submit" class="btn btn-primary">Actualizar</button>
	<a href="<?= BASE_URL ?>botiquines" class="btn btn-secondary">Cancelar</a>
</form>