<?php
function km_a_metros($km) {
    return $km * 1000;
}

function metros_a_kilometros($metros) {
    return $metros / 1000;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = floatval($_POST["valor"]);
    $tipo = $_POST["tipo"];

    echo "<h2>Resultado:</h2>";

    if ($tipo == "km_a_m") {
        $resultado = km_a_metros($valor);
        echo "<p><strong>$valor kilómetros</strong> son <strong>$resultado metros</strong>.</p>";
    } elseif ($tipo == "m_a_km") {
        $resultado = metros_a_kilometros($valor);
        echo "<p><strong>$valor metros</strong> son <strong>$resultado kilómetros</strong>.</p>";
    } else {
        echo "<p style='color:red;'>Tipo de conversión no válido.</p>";
    }
}
?>
