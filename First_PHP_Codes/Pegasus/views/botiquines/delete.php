<?php
require_once __DIR__ . '/../../config/config.php';
?>

<h2>Eliminar Botiquín</h2>

<p>¿Estás seguro de que deseas eliminar el botiquín <strong><?= htmlspecialchars($botiquin['nombre']) ?></strong>?</p>

<form action="<?= BASE_URL ?>botiquines/delete/<?= $botiquin['id'] ?>" method="post">
  <button type="submit" class="btn btn-danger">Sí, eliminar</button>
  <a href="<?= BASE_URL ?>botiquines" class="btn btn-secondary">Cancelar</a>
</form>