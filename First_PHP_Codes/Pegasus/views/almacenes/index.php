<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h2>Lista de Almacenes</h2>
<a href="<?= BASE_URL ?>almacenes/create">Crear nuevo almacén</a>

<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Planta</th>
			<th>Tipo</th>
			<th>Acciones</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($almacenes as $almacen): ?>
			<tr>
				<td><?= $almacen['id'] ?></td>
				<td><?= htmlspecialchars($almacen['id_planta']) ?></td>
				<td><?= htmlspecialchars($almacen['tipo']) ?></td>
				<td>
					<a href="<?= BASE_URL ?>almacenes/edit/<?= $almacen['id'] ?>">Editar</a> |
					<a href="<?= BASE_URL ?>almacenes/delete/<?= $almacen['id'] ?>">Eliminar</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>