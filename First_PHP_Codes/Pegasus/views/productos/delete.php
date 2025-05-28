<?php
require_once __DIR__ . '/../../config/config.php';
?>

<div class="container">
  <h2 class="my-4 text-danger">Eliminar Producto</h2>

  <div class="alert alert-warning">
    <p>¿Estás seguro de que deseas eliminar el siguiente producto?</p>
    <ul>
      <li><strong>Código:</strong> <?= htmlspecialchars($producto['codigo']) ?></li>
      <li><strong>Descripción:</strong> <?= htmlspecialchars($producto['descripcion']) ?></li>
    </ul>
  </div>

  <form action="<?= BASE_URL ?>productos/destroy/<?= $producto['id'] ?>" method="POST">
    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
    <a href="<?= BASE_URL ?>productos" class="btn btn-secondary">Cancelar</a>
  </form>
</div>