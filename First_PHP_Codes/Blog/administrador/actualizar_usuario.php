<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'administrador') {
    header("Location: ../inicio.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];

    $conexion = new mysqli("localhost", "root", "", "php");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $stmt = $conexion->prepare("UPDATE formulario_php SET usuario = ?, correo = ?, rol = ?, nombre = ?, apellido_1 = ?, apellido_2 = ? WHERE dni = ?");
    $stmt->bind_param("sssssss", $usuario, $email, $rol, $nombre, $apellido1, $apellido2, $dni);

    if ($stmt->execute()) {
        echo "<script>alert('Usuario actualizado correctamente.'); window.location.href = 'list.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario.'); window.history.back();</script>";
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso no permitido.";
}
?>
