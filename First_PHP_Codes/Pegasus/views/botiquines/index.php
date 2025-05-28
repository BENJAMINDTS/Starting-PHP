<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h2>Gestión de Botiquines</h2>

<a href="<?= BASE_URL ?>botiquines/create" class="btn btn-primary">Nuevo Botiquín</a>

<?php if (!empty($botiquines)) : ?>
	<table class="table">
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Planta</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($botiquines as $botiquin) : ?>
				<tr>
					<td><?= $botiquin['id'] ?></td>
					<td><?= htmlspecialchars($botiquin['nombre']) ?></td>
					<td><?= htmlspecialchars($botiquin['id_planta']) ?></td>
					<td>
						<a href="<?= BASE_URL ?>botiquines/edit/<?= $botiquin['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
						<a href="<?= BASE_URL ?>botiquines/delete/<?= $botiquin['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar botiquín?')">Eliminar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php else : ?>
	<p>No hay botiquines registrados.</p>
<?php endif; ?>