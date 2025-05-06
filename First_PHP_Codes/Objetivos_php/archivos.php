<?php

$archivo = 'datos.txt';     
$contenido = 'Hola, soy un archivo de texto.';

$fp = fopen($archivo, 'w');

if ($fp) {
    fwrite($fp, $contenido);
    // Cerrar el archivo
    fclose($fp);
    echo "Archivo creado y contenido escrito correctamente.";
} else {
    echo "Error al abrir el archivo.";
}

$fp = fopen($archivo, 'r');
if ($fp) {
    $contenido = fread($fp, filesize($archivo));
    fclose($fp);
    echo "<br>Contenido del archivo: " . $contenido;
} else {
    echo "Error al abrir el archivo.";
}
?>