<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Eliminar Usuario</h1>

<p>¿Seguro que deseas eliminar al usuario <strong><?= htmlspecialchars($usuario->nombre) ?></strong>?</p>

<form action="<?= BASE_URL ?>usuarios/delete/<?= $usuario->id ?>" method="POST">
    <button type="submit">Sí, eliminar</button>
    <a href="<?= BASE_URL ?>usuarios">Cancelar</a>
</form>
