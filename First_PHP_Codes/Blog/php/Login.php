<?php
session_start();

$server = "localhost";
$user = "root";
$password = "";
$database = "php";
$ip = $_SERVER['REMOTE_ADDR'];
$fecha = date("Y-m-d H:i:s");
$operacion = "login";
$resultado = 1;

$conexion = mysqli_connect($server, $user, $password, $database);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = trim($_POST['dni']);
    $contrasena = trim($_POST['contrasena']);

    $sql = "SELECT Contrasena, usuario, rol FROM formulario_php WHERE dni = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $dni);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hash_guardado, $usuario, $rol);

    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($contrasena, $hash_guardado)) {
            if (password_needs_rehash($hash_guardado, PASSWORD_DEFAULT)) {
                $nuevo_hash = password_hash($contrasena, PASSWORD_DEFAULT);
                $update_sql = "UPDATE formulario_php SET Contrasena = ? WHERE dni = ?";
                $update_stmt = mysqli_prepare($conexion, $update_sql);
                mysqli_stmt_bind_param($update_stmt, "ss", $nuevo_hash, $dni);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }

            session_regenerate_id(true);
            $_SESSION['dni'] = $dni;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['rol'] = $rol;
            $resultado = 0;

            $stmt->close();


            $update_activity = $conexion->prepare("UPDATE formulario_php SET ultima_actividad = NOW() WHERE usuario = ?");
            $update_activity->bind_param("s", $usuario);
            $update_activity->execute();
            $update_activity->close();

            $log_sql = "INSERT INTO logs (ip, fecha, operacion, resultado) VALUES (?, ?, ?, ?)";
            $log_stmt = $conexion->prepare($log_sql);
            $log_stmt->bind_param("ssss", $ip, $fecha, $operacion, $resultado);
            $log_stmt->execute();
            $log_stmt->close();

            mysqli_close($conexion);
            header("Location: /Blog/Inicio.php");
            exit;
        } else {
            $stmt->close();
            echo "<script>alert('Contraseña incorrecta.'); window.history.back();</script>";
            $resultado = 1;
        }
    } else {
        $stmt->close();
        echo "<script>alert('DNI no encontrado.'); window.history.back();</script>";
        $resultado = 1;
    }
}

$log_sql = "INSERT INTO logs (ip, fecha, operacion, resultado) VALUES (?, ?, ?, ?)";
$log_stmt = $conexion->prepare($log_sql);
$log_stmt->bind_param("sssi", $ip, $fecha, $operacion, $resultado);
$log_stmt->execute();
$log_stmt->close();

mysqli_close($conexion);
?>
