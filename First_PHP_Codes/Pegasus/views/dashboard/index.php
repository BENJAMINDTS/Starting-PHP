<!-- views/dashboard/index.php -->
<?php
require_once __DIR__ . '/../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">


<body>

	<h1 style="text-align:center;">Panel de Control</h1>

	<div class="dashboard-container">
		<div class="card">
			<h3>Hospitales</h3>
			<p><?= htmlspecialchars($totalHospitales) ?></p>
		</div>
		<div class="card">
			<h3>Plantas</h3>
			<p><?= htmlspecialchars($totalPlantas) ?></p>
		</div>
		<div class="card">
			<h3>Productos</h3>
			<p><?= htmlspecialchars($totalProductos) ?></p>
		</div>
		<div class="card">
			<h3>Usuarios</h3>
			<p><?= htmlspecialchars($totalUsuarios) ?></p>
		</div>
	</div>

</body>

</html>