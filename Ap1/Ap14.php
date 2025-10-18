<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calculadora de Áreas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f4f8;
            padding: 30px;
        }
        h1 {
            color: #2c3e50;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
            max-width: 400px;
        }
        label, select, input {
            display: block;
            margin-bottom: 10px;
            width: 100%;
        }
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .resultado {
            margin-top: 20px;
            padding: 10px;
            background: #ecf0f1;
            border-radius: 8px;
        }
    </style>
    <script>
        // Script para mostrar los campos necesarios según la figura seleccionada
        function mostrarCampos() {
            const figura = document.getElementById('figura').value;
            document.getElementById('campos-triangulo').style.display = figura === 'triangulo' ? 'block' : 'none';
            document.getElementById('campos-rectangulo').style.display = figura === 'rectangulo' ? 'block' : 'none';
            document.getElementById('campos-circulo').style.display = figura === 'circulo' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<h1>Calculadora de Áreas</h1>
<form method="post">
    <label for="figura">Selecciona una figura:</label>
    <select name="figura" id="figura" onchange="mostrarCampos()">
        <option value="">-- Selecciona --</option>
        <option value="triangulo">Triángulo</option>
        <option value="rectangulo">Rectángulo</option>
        <option value="circulo">Círculo</option>
    </select>

    <div id="campos-triangulo" style="display:none;">
        <label>Base:</label>
        <input type="number" name="baseT" step="any" min="0">
        <label>Altura:</label>
        <input type="number" name="alturaT" step="any" min="0">
    </div>

    <div id="campos-rectangulo" style="display:none;">
        <label>Base:</label>
        <input type="number" name="base" step="any" min="0">
        <label>Altura:</label>
        <input type="number" name="altura" step="any" min="0">
    </div>

    <div id="campos-circulo" style="display:none;">
        <label>Radio:</label>
        <input type="number" name="radio" step="any" min="0">
    </div>

    <button type="submit">Calcular Área</button>
</form>

<?php
function calcularAreaTriangulo($base, $altura) {
    return ($base * $altura) / 2;
}

function calcularAreaRectangulo($base, $altura) {
    return $base * $altura;
}

function calcularAreaCirculo($radio) {
    return pi() * pow($radio, 2);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $figura = $_POST['figura'];

    switch ($figura) {
        case "triangulo":
            $base = $_POST['baseT'];
            $altura = $_POST['alturaT'];
            if (empty($base) || empty($altura)) {
                echo "<div class='resultado'><h3>Por favor, completa todos los campos.</h3></div>";
            } else {
                $area = calcularAreaTriangulo($base, $altura);
                echo "<div class='resultado'><h3>El área del triángulo es: $area</h3></div>";
            }
            break;

        case "rectangulo":
            $base = $_POST['base'];
            $altura = $_POST['altura'];
            if (empty($base) || empty($altura)) {
                echo "<div class='resultado'><h3>Por favor, completa todos los campos.</h3></div>";
            } else {
                $area = calcularAreaRectangulo($base, $altura);
                echo "<div class='resultado'><h3>El área del rectángulo es: $area</h3></div>";
            }
            break;

        case "circulo":
            $radio = $_POST['radio'];
            if (empty($radio)) {
                echo "<div class='resultado'><h3>Por favor, completa todos los campos.</h3></div>";
            } else {
                $area = calcularAreaCirculo($radio);
                echo "<div class='resultado'><h3>El área del círculo es: $area</h3></div>";
            }
            break;

        default:
            echo "<div class='resultado'><h3>Opción no válida.</h3></div>";
            break;
    }
}
?>
</body>
</html>
