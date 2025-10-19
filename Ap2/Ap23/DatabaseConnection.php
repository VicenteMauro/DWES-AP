<?php


class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private mysqli $conn;

    private function __construct(string $host, string $username, string $password, string $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error . ". Línea: " . __LINE__);
        }
    }

    public static function getInstance(string $host, string $username, string $password, string $database): DatabaseConnection
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection($host, $username, $password, $database);
        }
        return self::$instance;
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    public function close(): void
    {
        $this->conn->close();
        self::$instance = null;
    }
}
?>