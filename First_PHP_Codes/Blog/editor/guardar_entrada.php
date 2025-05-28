<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'editor') {
    header("Location: ../inicio.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $resumen = $_POST['resumen'];
    $contenido = $_POST['contenido'];

    // Procesar la imagen
    $imagen = $_FILES['imagen'];
    $nombreImagen = basename($imagen['name']);
    $rutaDestino = "../img/" . $nombreImagen;

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        $contenidoHTML = "<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>" . htmlspecialchars($titulo) . "</title>
  <link rel='stylesheet' href='../css/inicio.css'>
</head>
<body>

  <header>
    <h1>" . htmlspecialchars($titulo) . "</h1>
    <p><em>" . htmlspecialchars($fecha) . "</em></p>
  </header>

  <div class='container'>
    <img src='../img/" . htmlspecialchars($nombreImagen) . "' alt='" . htmlspecialchars($titulo) . "' style='width: 100%; border-radius: 8px; margin-bottom: 1rem;'>
    <!-- RESUMEN: " . htmlspecialchars($resumen) . " -->";

        $parrafos = explode("\n\n", trim($contenido));
        foreach ($parrafos as $p) {
            $contenidoHTML .= "<p>" . nl2br(htmlspecialchars(trim($p))) . "</p>";
        }

        $contenidoHTML .= "

  <footer>
    <p>&copy; 2025 Mi Blog Personal. Todos los derechos reservados.</p>
  </footer>

</body>
</html>";

        $nombreArchivo = "../Entradas/" . str_replace(' ', '_', strtolower($titulo)) . ".html";
        file_put_contents($nombreArchivo, $contenidoHTML);

        header("Location: ../inicio.php");
        exit();
    } else {
        echo "Error al subir la imagen.";
    }
} else {
    echo "Acceso no permitido.";
}
