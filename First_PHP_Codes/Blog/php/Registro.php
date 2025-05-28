<?php
session_start();

$server = "localhost";
$user = "root";
$password = "";
$database = "php";
$ip = $_SERVER['REMOTE_ADDR'];
$fecha = date("Y-m-d H:i:s");
$operacion = "registro";
$resultado = 1;

$conexion = mysqli_connect($server, $user, $password, $database);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = trim($_POST['usuario']);
    $dni = trim($_POST['dni']);
    $nombre = trim($_POST['nombre']);
    $contrasena = trim($_POST['contrasena']);
    $apellido1 = trim($_POST['apellido1']);
    $apellido2 = trim($_POST['apellido2']);
    $correo = trim($_POST['correo']);

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    if (!preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
        die("Error: El DNI debe tener 8 números seguidos de una letra mayúscula (ejemplo: 12345678Z).");
    }

    if (!preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/", $contrasena)) {
        echo "<script>alert('La contraseña debe tener al menos una mayúscula, un número, un signo y mínimo 8 caracteres.'); window.history.back();</script>";
        exit;
    }

    $check = $conexion->prepare("SELECT dni FROM formulario_php WHERE dni = ?");
    $check->bind_param("s", $dni);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Este DNI ya está registrado.'); window.history.back();</script>";
        $check->close();
    } else {
        $check->close();

        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $conexion->prepare("INSERT INTO formulario_php (usuario, dni, nombre, contrasena, apellido_1, apellido_2, correo) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $usuario, $dni, $nombre, $contrasena_hash, $apellido1, $apellido2, $correo);

        setcookie("usuario", $usuario, time() + 3600, "/");

        if ($stmt->execute()) {
            $resultado = 0;
            $stmt->close();

            $log_sql = "INSERT INTO logs (ip, fecha, operacion, resultado) VALUES (?, ?, ?, ?)";
            $log_stmt = $conexion->prepare($log_sql);
            $log_stmt->bind_param("ssss", $ip, $fecha, $operacion, $resultado);
            $log_stmt->execute();
            $log_stmt->close();

            mysqli_close($conexion);
            header("Location: ../inicio.php");
            exit();
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
            $stmt->close();
        }
    }
}

$log_sql = "INSERT INTO logs (ip, fecha, operacion, resultado) VALUES (?, ?, ?, ?)";
$log_stmt = $conexion->prepare($log_sql);
$log_stmt->bind_param("sssi", $ip, $fecha, $operacion, $resultado);
$log_stmt->execute();
$log_stmt->close();

mysqli_close($conexion);
?>
