<?php
/**
 * Clase Task
 * 
 * Modelo para la gestión de tareas en la base de datos.
 * Proporciona métodos para operaciones CRUD de tareas.
 */
class Task {
    private $conn;
    private $table = "tasks";

    /**
     * Constructor de la clase
     * 
     * @param PDO $db Instancia de conexión a la base de datos
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Obtiene todas las tareas de la base de datos
     * 
     * @return array Lista de tareas
     */
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva tarea en la base de datos
     * 
     * @param int $user_id ID del usuario al que pertenece la tarea
     * @param string $title Título de la tarea
     * @return bool True si se creó correctamente, False en caso contrario
     */
    public function create($user_id, $title) {
        $sql = "INSERT INTO {$this->table} (user_id, title) VALUES (:user_id, :title)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'user_id' => $user_id,
            'title' => $title
        ]);
    }

    /**
     * Marca una tarea como completada
     * 
     * @param int $id ID de la tarea
     * @return bool True si se actualizó correctamente, False en caso contrario
     */
    public function complete($id) {
        $sql = "UPDATE {$this->table} SET completed = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Elimina una tarea de la base de datos
     * 
     * @param int $id ID de la tarea
     * @return bool True si se eliminó correctamente, False en caso contrario
     */
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
