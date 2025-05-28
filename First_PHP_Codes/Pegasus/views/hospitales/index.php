<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h1>Hospitales</h1>
<a href="<?= BASE_URL ?>hospitales/create">Crear nuevo hospital</a>
<table border="1" cellpadding="5">
	<thead>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php if (!empty($hospitales)): ?>
			<?php foreach ($hospitales as $hospital): ?>
				<tr>
					<td><?= htmlspecialchars($hospital['id']) ?></td>
					<td><?= htmlspecialchars($hospital['nombre']) ?></td>
					<td>
						<a href="<?= BASE_URL ?>hospitales/show/<?= $hospital['id'] ?>">Ver</a> |
						<a href="<?= BASE_URL ?>hospitales/edit/<?= $hospital['id'] ?>">Editar</a> |
						<a href="<?= BASE_URL ?>hospitales/delete/<?= $hospital['id'] ?>" onclick="return confirm('¿Eliminar hospital?')">Eliminar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="3">No hay hospitales registrados.</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>