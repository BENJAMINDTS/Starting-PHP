<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'editor') {
    header("Location: ../inicio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Entrada</title>
    <link rel="stylesheet" href="../CSS/entradas.css">
</head>
<body>

<h2>Crear Nueva Entrada</h2>

<form action="guardar_entrada.php" method="post" enctype="multipart/form-data">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" id="titulo" required>

    <label for="fecha">Fecha de publicación:</label>
    <input type="date" name="fecha" id="fecha" required>

    <label for="imagen">Selecciona una imagen:</label>
    <input type="file" name="imagen" id="imagen" accept="image/*" required>

    <label for="resumen">Resumen de la entrada</label>
    <input type="text" name="resumen" id="resumen" required>

    <label for="contenido">Contenido (separa los párrafos con doble salto de línea):</label>
    <textarea name="contenido" id="contenido" rows="12" required></textarea>

    <input type="submit" value="Crear Entrada">
</form>

<a href="../inicio.php">← Volver al Inicio</a>

</body>
</html>
