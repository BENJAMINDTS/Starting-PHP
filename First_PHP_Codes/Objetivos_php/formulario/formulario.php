<?php 

$nota = $_POST['nota']; 
$nombre =$_POST["nombre"];
$apellidos = $_POST["apellidos"];

echo"$nombre $apellidos <br>";

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

?> 