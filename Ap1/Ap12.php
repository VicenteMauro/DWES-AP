<?php

try {

    if (empty($_GET)) {
        throw new Exception("No se ha recibido ningún dato o es un valor nulo.");
    }

    $datos = $_GET;

    foreach ($datos as $key => $value) {

        if ($value === null || $value === '' || strtolower($value) === 'null') {
            echo "No se ha recibido ningún dato o es un valor nulo.<br>";
        }
        elseif (is_numeric($value)) {
            echo "Se ha recibido un número '$value' para la clave '$key'.<br>";
        }
        else {
            echo "Se ha recibido una cadena de caracteres '$value' para la clave '$key'.<br>";
        }
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

