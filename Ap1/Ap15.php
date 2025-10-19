<?php

$host = "mariadb-server";
$username = "root";
$password = "root";
$database = "AP1";

// Conexión a BBDD
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Se ha producido el siguiente error: " . $conn->connect_error . ". En la línea: " . __LINE__);
}

try {
    // Extraer y mostrar todos los usuarios
    $sql = "SELECT id, nombre, estado FROM usuarios";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Error al consultar usuarios: " . $conn->error, __LINE__);
    }

    while ($row = $result->fetch_assoc()) {
        $estadoTexto = $row['estado'] == 1 ? 'activo' : 'inactivo';
        echo "El usuario {$row['nombre']} posee la id: {$row['id']} y su estado es: {$estadoTexto}<br>";
    }

    // Insertar nuevo usuario Mauro con estado 1
    $nuevoNombre = "Mauro";
    $nuevoEstado = 1;

    $sqlInsert = "INSERT INTO usuarios (nombre, estado) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        throw new Exception("Error al preparar inserción: " . $conn->error, __LINE__);
    }

    $stmtInsert->bind_param("si", $nuevoNombre, $nuevoEstado);
    if (!$stmtInsert->execute()) {
        throw new Exception("Error al ejecutar inserción: " . $stmtInsert->error, __LINE__);
    }

    $nuevaId = $stmtInsert->insert_id;
    echo "Se ha realizado la inserción con la nueva id: $nuevaId<br>";
    $stmtInsert->close();

    // Actualizar estado del nuevo usuario a 0 (inactivo)
    $estadoActualizado = 0;
    $sqlUpdate = "UPDATE usuarios SET estado = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    if (!$stmtUpdate) {
        throw new Exception("Error al preparar actualización: " . $conn->error, __LINE__);
    }

    $stmtUpdate->bind_param("ii", $estadoActualizado, $nuevaId);
    if (!$stmtUpdate->execute()) {
        throw new Exception("Error al ejecutar actualización: " . $stmtUpdate->error, __LINE__);
    }

    echo "Se ha realizado correctamente la actualización de la id: $nuevaId<br>";
    $stmtUpdate->close();

    // Borrar el nuevo usuario
    $sqlDelete = "DELETE FROM usuarios WHERE id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if (!$stmtDelete) {
        throw new Exception("Error al preparar borrado: " . $conn->error, __LINE__);
    }

    $stmtDelete->bind_param("i", $nuevaId);
    if (!$stmtDelete->execute()) {
        throw new Exception("Error al ejecutar borrado: " . $stmtDelete->error, __LINE__);
    }

    echo "Se ha realizado correctamente el borrado de la id: $nuevaId<br>";
    $stmtDelete->close();

} catch (Exception $e) {
    echo "Se ha producido el siguiente error: " . $e->getMessage() . ". En la línea: " . $e->getCode();
    exit;
} finally {
    // Cerrar conexión
    $conn->close();
}
?>