<?php 

if ($_SERVER["REQUEST_METHOD"] =="POST"){
    $nota =trim($_POST['nota']) ;
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellidos']);

    if ($nota == "" || $nombre =="" || $apellido == "") {
        echo "Todos los campos son obligatorios";
    } else {
        echo "Los datos son correctos <br>";
        echo "Nombre: $nombre <br>";
        echo "Apellidos: $apellido <br>";
        if ($nota >=0 && $nota <5) {
            echo "Insuficiente";
            } elseif ($nota >=5 && $nota <6) {
                echo "Suficiente";
            } elseif ($nota >=6 && $nota <7) {
                echo "Bien";
            } elseif ($nota >=7 && $nota <9) {
                echo "Notable";
            } elseif ($nota >=9 && $nota <=10) {
                echo "Sobresaliente";
            } else {
                echo "Nota no válida";
            }
    }
}

?> 