<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../utils/Response.php';

/**
 * Clase TaskController
 * 
 * Controlador para manejar las peticiones relacionadas con tareas.
 * Implementa los endpoints para obtener, crear, actualizar y eliminar tareas.
 */
class TaskController {
    private $db;
    private $model;

    /**
     * Constructor de la clase
     * 
     * @param PDO $db Instancia de conexión a la base de datos
     */
    public function __construct($db) {
        $this->db = $db;
        $this->model = new Task($db);
    }

    /**
     * Obtiene todas las tareas
     * Endpoint: GET /tasks
     */
    public function index() {
        $tasks = $this->model->getAll();
        Response::json($tasks);
    }

    /**
     * Crea una nueva tarea
     * Endpoint: POST /tasks
     */
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Validar datos requeridos
        if (!isset($data['user_id'], $data['title'])) {
            Response::json(["error" => "Se requieren los campos user_id y title"], 400);
            return;
        }

        // Validar que el user_id sea un número
        if (!is_numeric($data['user_id'])) {
            Response::json(["error" => "El user_id debe ser un número"], 400);
            return;
        }

        if ($this->model->create($data['user_id'], $data['title'])) {
            Response::json(["message" => "Tarea creada exitosamente"], 201);
        } else {
            Response::json(["error" => "Error al crear la tarea"], 500);
        }
    }

    /**
     * Marca una tarea como completada
     * Endpoint: PUT /tasks/{id}
     * 
     * @param int $id ID de la tarea
     */
    public function complete($id) {
        if (!is_numeric($id)) {
            Response::json(["error" => "El ID debe ser un número"], 400);
            return;
        }

        if ($this->model->complete($id)) {
            Response::json(["message" => "Tarea marcada como completada"]);
        } else {
            Response::json(["error" => "Tarea no encontrada"], 404);
        }
    }

    /**
     * Elimina una tarea
     * Endpoint: DELETE /tasks/{id}
     * 
     * @param int $id ID de la tarea
     */
    public function delete($id) {
        if (!is_numeric($id)) {
            Response::json(["error" => "El ID debe ser un número"], 400);
            return;
        }

        if ($this->model->delete($id)) {
            Response::json(["message" => "Tarea eliminada exitosamente"]);
        } else {
            Response::json(["error" => "Tarea no encontrada"], 404);
        }
    }
}
