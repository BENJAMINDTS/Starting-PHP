<?php
require_once __DIR__ . '/../../config/config.php';
?>

<div class="container">
	<h2 class="my-4">Listado de Productos</h2>

	<?php if (!empty($_SESSION['success'])): ?>
		<div class="alert alert-success">
			<?= $_SESSION['success'];
			unset($_SESSION['success']); ?>
		</div>
	<?php endif; ?>

	<?php if (!empty($_SESSION['error'])): ?>
		<div class="alert alert-danger">
			<?= $_SESSION['error'];
			unset($_SESSION['error']); ?>
		</div>
	<?php endif; ?>

	<a href="<?= BASE_URL ?>productos/create" class="btn btn-primary mb-3">Nuevo Producto</a>

	<table class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Código</th>
				<th>Descripción</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($productos as $producto): ?>
				<tr>
					<td><?= htmlspecialchars($producto['id']) ?></td>
					<td><?= htmlspecialchars($producto['codigo']) ?></td>
					<td><?= htmlspecialchars($producto['descripcion']) ?></td>
					<td>
						<a href="<?= BASE_URL ?>productos/edit/<?= $producto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
						<a href="<?= BASE_URL ?>productos/delete/<?= $producto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
					</td>
				</tr>
			<?php endforeach; ?>

			<?php if (empty($productos)): ?>
				<tr>
					<td colspan="4">No hay productos registrados.</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>