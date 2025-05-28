<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../inicio.php");
    exit();
}

if (!isset($_GET['dni'])) {
    echo "DNI no proporcionado.";
    exit();
}

$dni = $_GET['dni'];

$conexion = new mysqli("localhost", "root", "", "php");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$stmt = $conexion->prepare("SELECT usuario, rol, correo, nombre, apellido_1, apellido_2 FROM formulario_php WHERE dni = ?");
$stmt->bind_param("s", $dni);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Usuario no encontrado.";
    exit();
}

$usuario = $result->fetch_assoc();
$stmt->close();
$conexion->close();
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../CSS/editar.css">
<h2>Editar Usuario</h2>
<form action="actualizar_usuario.php" method="post">
    <input type="hidden" name="dni" value="<?= htmlspecialchars($dni) ?>">

    Usuario: <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>"><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($usuario['correo']) ?>"><br>
    Rol: 
    <select name="rol">
        <option value="usuario" <?= $usuario['rol'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
        <option value="editor" <?= $usuario['rol'] === 'editor' ? 'selected' : '' ?>>Editor</option>
        <option value="administrador" <?= $usuario['rol'] === 'administrador' ? 'selected' : '' ?>>Administrador</option>
    </select><br>
    Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>"><br>
    Apellido 1: <input type="text" name="apellido1" value="<?= htmlspecialchars($usuario['apellido_1']) ?>"><br>
    Apellido 2: <input type="text" name="apellido2" value="<?= htmlspecialchars($usuario['apellido_2']) ?>"><br>

    <input type="submit" value="Actualizar">
</form>

</html>
