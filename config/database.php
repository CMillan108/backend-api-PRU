<?php
/**
 * Clase Database
 * 
 * Maneja la conexión a la base de datos MySQL utilizando PDO.
 * Implementa el patrón Singleton para mantener una única instancia de conexión.
 */
class Database {
    // Configuración de la base de datos
    private $host = "localhost";
    private $db_name = "task_api";
    private $username = "root";
    private $password = "";
    public $conn;

    /**
     * Establece la conexión con la base de datos
     * 
     * @return PDO|null Retorna la conexión PDO o null si hay error
     */
    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            echo json_encode(["error" => "Error de conexión a la base de datos"]);
            exit;
        }
        return $this->conn;
    }
}
