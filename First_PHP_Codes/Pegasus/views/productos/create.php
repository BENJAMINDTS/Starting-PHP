<?php
require_once __DIR__ . '/../../config/config.php';
?>

<div class="container">
    <h2 class="my-4">Nuevo Producto</h2>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'];
            unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>productos/store" method="POST">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" id="codigo" name="codigo" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>productos" class="btn btn-secondary">Cancelar</a>
    </form>
</div>