<?php

require_once 'DatabaseConnection.php';

// Parámetros de conexión
$host = "mariadb-server";
$username = "root";
$password = "root";
$database = "AP1";

// Obtener instancia única
$db = DatabaseConnection::getInstance($host, $username, $password, $database);
$conn = $db->getConnection();

// Mostrar usuarios
function mostrarUsuarios(mysqli $conn): void {
    $sql = "SELECT id, nombre, estado FROM usuarios";
    $result = $conn->query($sql);

    if ($result) {
        echo "Lista de usuarios:<br>";
        while ($row = $result->fetch_assoc()) {
            $estadoTexto = $row['estado'] == 1 ? 'activo' : 'inactivo';
            echo "Usuario: {$row['nombre']} | ID: {$row['id']} | Estado: {$estadoTexto}<br>";
        }
    } else {
        echo "Error en la consulta: " . $conn->error . "<br>";
    }
}

// Insertar usuario
function insertUsuario(mysqli $conn, string $nombre, int $estado): int {
    $sql = "INSERT INTO usuarios (nombre, estado) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $estado);
    $stmt->execute();
    $id = $stmt->insert_id;
    $stmt->close();
    echo "<br>Usuario '$nombre' insertado con ID: $id<br>";
    return $id;
}

// Actualizar estado
function updateUsuario(mysqli $conn, int $id, int $nuevoEstado): void {
    $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $nuevoEstado, $id);
    $stmt->execute();
    $stmt->close();
    echo "Estado del usuario con ID $id actualizado a: $nuevoEstado<br>";
}

//  Eliminar usuario
function deleteUsuario(mysqli $conn, int $id): void {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    echo "Usuario con ID $id eliminado correctamente<br>";
}

// Ejemplo
mostrarUsuarios($conn);
$nuevaId = insertUsuario($conn, "Mauro", 1);
updateUsuario($conn, $nuevaId, 0);
deleteUsuario($conn, $nuevaId);
$db->close();

?>

