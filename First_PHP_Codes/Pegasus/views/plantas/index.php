<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h1>Listado de Plantas</h1>

<a href="<?= BASE_URL ?>plantas/create">Crear nueva planta</a>

<?php if (isset($success)): ?>
	<p style="color: green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<?php if (isset($error)): ?>
	<p style="color: red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Hospital</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if (empty($plantas)): ?>
			<tr>
				<td colspan="4">No hay plantas registradas.</td>
			</tr>
		<?php else: ?>
			<?php foreach ($plantas as $planta): ?>
				<tr>
					<td><?= htmlspecialchars($planta['id']) ?></td>
					<td><?= htmlspecialchars($planta['nombre']) ?></td>
					<td><?= htmlspecialchars($planta['hospital_nombre']) ?></td>
					<td>
						<a href="<?= BASE_URL ?>plantas/edit/<?= $planta['id'] ?>">Editar</a> |
						<a href="<?= BASE_URL ?>plantas/delete/<?= $planta['id'] ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta planta?')">Eliminar</a> |
						<a href="<?= BASE_URL ?>plantas/show/<?= $planta['id'] ?>">Ver</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>