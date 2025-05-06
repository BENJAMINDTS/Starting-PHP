<?php

 function tabla_multiplicar($numero) {
    echo "<h2>Tabla de multiplicar del $numero</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Multiplicación</th><th>Resultado</th></tr>";
    for ($i = 1; $i <= 10; $i++) {
        $resultado = $numero * $i;
        echo "<tr><td>$numero x $i</td><td>$resultado</td></tr>";
    }
    echo "</table>";
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valor = floatval($_POST["valor"]);
        
    
        tabla_multiplicar($valor);
    
    }
?>