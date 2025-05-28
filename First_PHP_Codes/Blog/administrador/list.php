<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
  header("Location: ../inicio.php");
  exit();
}

$server = "localhost";
$user = "root";
$password = "";
$database = "php";

$conexion = mysqli_connect($server, $user, $password, $database);
if (!$conexion) {
  die("Error de conexión: " . mysqli_connect_error());
}

$sql = "SELECT * FROM formulario_php";
$result = mysqli_query($conexion, $sql);
if (!$result) {
  die("Error en la consulta: " . mysqli_error($conexion));
}

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Listado de Usuarios</title>
    <link rel='stylesheet' href='../CSS/list.css'>
</head>
<body>

    <h2>Listado de Usuarios</h2>
    
 <div>
 <a class= volver href='../inicio.php'>← Volver al Inicio</a>

</div>

  <table border='1' cellpadding='5' cellspacing='0'>
    <tr>
      <th>DNI</th>
      <th>Usuario</th>
      <th>Contraseña</th>
      <th>Rol</th>
      <th>Email</th>
      <th>Nombre</th>
      <th>Apellido 1</th>
      <th>Apellido 2</th>
      <th>Online</th>
      <th>Acciones</th>
    </tr>";

while ($row = mysqli_fetch_assoc($result)) {
  $dni = $row['DNI'];
  $usuario = $row['Usuario'];
  $contrasena = $row['Contrasena'];
  $rol = $row['rol'];
  $email = $row['Correo'];
  $nombre = $row['Nombre'];
  $apellido1 = $row['Apellido_1'];
  $apellido2 = $row['Apellido_2'];
  $ultima_actividad = $row['ultima_actividad'];

  // Determinar si el usuario está online (últimos 5 minutos)
  $online = (strtotime($ultima_actividad) > time() - 300)
    ? "<span class='online'>🟢 Sí</span>"
    : "<span class='offline'>🔴 No</span>";

  echo "<tr>
            <td>" . htmlspecialchars($dni) . "</td>
            <td>" . htmlspecialchars($usuario) . "</td>
            <td>" . htmlspecialchars($contrasena) . "</td>
            <td>" . htmlspecialchars($rol) . "</td>
            <td>" . htmlspecialchars($email) . "</td>
            <td>" . htmlspecialchars($nombre) . "</td>
            <td>" . htmlspecialchars($apellido1) . "</td>
            <td>" . htmlspecialchars($apellido2) . "</td>
            <td>$online</td>
            <td><a href='editar_usuario.php?dni=" . urlencode($dni) . "'>Editar</a></td>
          </tr>";
}

echo "</table>
</body>
</html>";

mysqli_close($conexion);
