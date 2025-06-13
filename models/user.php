<?php
/**
 * Clase User
 * 
 * Modelo para la gestión de usuarios en la base de datos.
 * Proporciona métodos para operaciones CRUD de usuarios.
 */
class User {
    private $conn;
    private $table = "users";

    /**
     * Constructor de la clase
     * 
     * @param PDO $db Instancia de conexión a la base de datos
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todos los usuarios de la base de datos
     * 
     * @return array Lista de usuarios
     */
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario en la base de datos
     * 
     * @param string $name Nombre del usuario
     * @param string $email Email del usuario
     * @return bool True si se creó correctamente, False en caso contrario
     */
    public function create($name, $email) {
        $sql = "INSERT INTO {$this->table} (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'name' => $name,
            'email' => $email
        ]);
    }
}
