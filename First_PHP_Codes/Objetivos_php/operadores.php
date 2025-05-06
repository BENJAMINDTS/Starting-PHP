<?php
// Declaración de variables de distintos tipos
$numero1 = 10; 
$numero2 = 5;  
define("PI", 3.14); // Constante
$texto = "Resultado: "; 

// Operadores aritméticos
$suma = $numero1 + $numero2; 
$resta = $numero1 - $numero2; 
$multiplicacion = $numero1 * PI; 
$division = $numero1 / $numero2; 
$modulo = $numero1 % $numero2; 

// Imprimir resultados
echo $texto . "Suma = " . $suma . "<br>";
echo $texto . "Resta = " . $resta . "<br>";
echo $texto . "Multiplicación = " . $multiplicacion . "<br>";
echo $texto . "División = " . $division . "<br>";
echo $texto . "Módulo = " . $modulo . "<br>";
?>