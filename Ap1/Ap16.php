<?php

class Database {
    private $host = "mariadb-server";
    private $username = "root";
    private $password = "root";
    private $database = "AP1";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Se ha producido el siguiente error: " . $this->conn->connect_error . ". En la línea: " . __LINE__);
        }
    }

    public function selectUsuarios() {
        try {
            $sql = "SELECT id, nombre, estado FROM usuarios";
            $result = $this->conn->query($sql);
            if (!$result) {
                throw new Exception("Error al consultar usuarios: " . $this->conn->error, __LINE__);
            }
            while ($row = $result->fetch_assoc()) {
                $estadoTexto = $row['estado'] == 1 ? 'activo' : 'inactivo';
                echo "El usuario {$row['nombre']} posee la id: {$row['id']} y su estado es: {$estadoTexto}<br>";
            }
        } catch (Exception $e) {
            echo "Se ha producido el siguiente error: " . $e->getMessage() . ". En la línea: " . $e->getCode();
            exit;
        }
    }

    public function insertUsuario($nombre, $estado) {
        try {
            $sql = "INSERT INTO usuarios (nombre, estado) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar inserción: " . $this->conn->error, __LINE__);
            }
            $stmt->bind_param("si", $nombre, $estado);
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar inserción: " . $stmt->error, __LINE__);
            }
            $id = $stmt->insert_id;
            echo "Se ha realizado la inserción con la nueva id: $id<br>";
            $stmt->close();
            return $id;
        } catch (Exception $e) {
            echo "Se ha producido el siguiente error: " . $e->getMessage() . ". En la línea: " . $e->getCode();
            exit;
        }
    }

    public function updateEstado($id, $nuevoEstado) {
        try {
            $sql = "UPDATE usuarios SET estado = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar actualización: " . $this->conn->error, __LINE__);
            }
            $stmt->bind_param("ii", $nuevoEstado, $id);
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar actualización: " . $stmt->error, __LINE__);
            }
            echo "Se ha realizado correctamente la actualización de la id: $id<br>";
            $stmt->close();
        } catch (Exception $e) {
            echo "Se ha producido el siguiente error: " . $e->getMessage() . ". En la línea: " . $e->getCode();
            exit;
        }
    }

    public function deleteUsuario($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error al preparar borrado: " . $this->conn->error, __LINE__);
            }
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar borrado: " . $stmt->error, __LINE__);
            }
            echo "Se ha realizado correctamente el borrado de la id: $id<br>";
            $stmt->close();
        } catch (Exception $e) {
            echo "Se ha producido el siguiente error: " . $e->getMessage() . ". En la línea: " . $e->getCode();
            exit;
        }
    }

    public function cerrarConexion() {
        $this->conn->close();
    }
}

// Conexión a BBDD AP1.sql
$db = new Database();

// Extraer y mostrar usuarios existentes.
$db->selectUsuarios();

// Insertar nuevo usuario Mauro con estado 1.
$nuevaId = $db->insertUsuario("Mauro", 1);

// Actualizar estado a 0.
$db->updateEstado($nuevaId, 0);

// Borrar el usuario insertado.
$db->deleteUsuario($nuevaId);

// Cerrar conexión.
$db->cerrarConexion();
?>