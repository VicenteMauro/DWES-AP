<?php
$datos = array();
try {
    if (empty($_GET)) {
        throw new Exception("No se ha recibido ningún dato");
    }

    $datos = $_GET;

    var_dump($datos);
    echo "<br>";
    foreach ($datos as $key => $value) {
        echo "Se ha recibido " . $value . " para la clave " . $key . "<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
