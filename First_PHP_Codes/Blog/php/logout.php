<?php
session_start();


$ip = $_SERVER['REMOTE_ADDR'];
$fecha = date("Y-m-d H:i:s");
$operacion = "logout";
$resultado = 1;


if (session_unset() !== false && session_destroy() !== false) {
    $resultado = 0;
}


$server = "localhost";
$user = "root";
$password = "";
$database = "php";

$conexion = mysqli_connect($server, $user, $password, $database);
if (!$conexion) {

    header("Location: ../inicio.php");
    exit;
}


$sql = "INSERT INTO logs (ip, fecha, operacion, resultado) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssi", $ip, $fecha, $operacion, $resultado);
    $stmt->execute();
    $stmt->close();
}

mysqli_close($conexion);

// Redirigir al usuario
header("Location: ../inicio.php");
exit;
