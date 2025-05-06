<?php 

$nombres = ["Benjamin", "Manu", "Jose"]; 

foreach ($nombres as $nombre) { 
    echo "$nombre<br>"; 
} 

echo("$nombres[0] <br>");
echo("$nombres[1] <br>");
echo("$nombres[2] <br>");

$departamentos = ["Madrid" => "Madrid", "Barcelona" => "Cataluña", "Valencia" => "Comunidad Valenciana"];
foreach ($departamentos as $clave => $valor) { 
    echo "$clave: $valor<br>"; 
}

echo("$departamentos[Madrid] <br>");
echo("$departamentos[Barcelona] <br>");
echo("$departamentos[Valencia] <br>");


?> 