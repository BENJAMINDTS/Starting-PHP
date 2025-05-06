<?php 

function saludar($nombre) { 
    return "Hola, $nombre <br>"; 
} 

echo saludar("Benjamin ");

function saludarOpcional($nombre, $saludo = "Hola") { 
    return "$saludo, $nombre <br>"; 
}

echo saludarOpcional("Benjamin", "Buenos días");

function sumar($a, $b) { 
    return $a + $b . "<br>"; 
}

echo sumar("4","6");



function incrementar(&$numero) { 
    $numero++; 
}
$valor = 0;
incrementar($valor); 
echo $valor. "<br>";





?> 