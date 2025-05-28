<?php
require_once __DIR__ . '/../../config/config.php';
?>
<h1>Detalles del Hospital</h1>
<p><strong>ID:</strong> <?= htmlspecialchars($hospital['id']) ?></p>
<p><strong>Nombre:</strong> <?= htmlspecialchars($hospital['nombre']) ?></p>
<a href="<?= BASE_URL ?>hospitales">Volver</a>