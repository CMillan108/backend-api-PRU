<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/Response.php';

/**
 * Clase UserController
 * 
 * Controlador para manejar las peticiones relacionadas con usuarios.
 * Implementa los endpoints para obtener y crear usuarios.
 */
class UserController {
    private $db;
    private $model;

    /**
     * Constructor de la clase
     * 
     * @param PDO $db Instancia de conexión a la base de datos
     */
    public function __construct($db) {
        $this->db = $db;
        $this->model = new User($db);
    }

    /**
     * Obtiene todos los usuarios
     * Endpoint: GET /users
     */
    public function index() {
        $users = $this->model->getAll();
        Response::json($users);
    }

    /**
     * Crea un nuevo usuario
     * Endpoint: POST /users
     */
    public function store() {
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Validar datos requeridos
        if (!isset($data['name'], $data['email'])) {
            Response::json(["error" => "Se requieren los campos name y email"], 400);
            return;
        }

        // Validar formato de email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            Response::json(["error" => "El formato del email no es válido"], 400);
            return;
        }

        if ($this->model->create($data['name'], $data['email'])) {
            Response::json(["message" => "Usuario creado exitosamente"], 201);
        } else {
            Response::json(["error" => "Error al crear el usuario"], 500);
        }
    }
}
