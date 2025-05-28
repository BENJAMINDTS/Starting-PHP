<?php
require_once __DIR__ . '/../../config/config.php';
?>

<div class="container">
    <h2 class="my-4">Detalle del Producto</h2>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?= htmlspecialchars($producto['id']) ?></td>
        </tr>
        <tr>
            <th>Código</th>
            <td><?= htmlspecialchars($producto['codigo']) ?></td>
        </tr>
        <tr>
            <th>Descripción</th>
            <td><?= htmlspecialchars($producto['descripcion']) ?></td>
        </tr>
    </table>

    <a href="<?= BASE_URL ?>productos" class="btn btn-secondary">Volver</a>
    <a href="<?= BASE_URL ?>productos/edit/<?= $producto['id'] ?>" class="btn btn-primary">Editar</a>
    <a href="<?= BASE_URL ?>productos/delete/<?= $producto['id'] ?>" class="btn btn-danger">Eliminar</a>
</div>
