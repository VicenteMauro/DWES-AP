<?php
$datos = [
    1 => "primero",
    3 => "segundo",
    5 => "tercero",
    7 => "cuarto",
    9 => "quinto",
    11 => "sexto"
];

(int)$suma = 0;
(int)$posicion = 1;
(bool)$par= false;
(bool)$impar = false;

foreach ($datos as $clave => $valor) {
    echo "<strong>Iteración $posicion:</strong><br>";
    echo "Clave: $clave | Valor: $valor<br>";

    $suma += $clave;
    echo "Suma total hasta ahora: $suma<br>";

    if ($posicion % 2 != 0) {
        echo "Estás en una posición impar.<br>";
        $impar = true;
        $par = false;
    } else {
        echo "Estás en una posición par.<br>";
        $par = true;
        $impar = false;
    }

   /* if ($suma > 20) {
        echo "El valor de la suma es mayor que 20.<br>";
    } elseif ($suma > 10) {
        echo "El valor de la suma es mayor que 10.<br>";
    } elseif ($suma > 5) {
        echo "El valor de la suma es mayor que 5.<br>";
    }*/
    $resultado = match (true){
        $suma > 20 => 'El valor es mayor que 20<br>',
        $suma > 10 => 'El valor es mayor que 10<br>',
        $suma > 5 => 'El valor es mayor a 5<br>',
        default => '<br>'
    };
    echo $resultado;
    echo "<hr>";
    $posicion++;
}
?>