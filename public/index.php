<?php
// Habilitar reporte de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log para debugging
error_log("Script iniciado");
error_log("REQUEST_URI: " . $_SERVER['REQUEST_URI']);
error_log("SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME']);
error_log("PHP_SELF: " . $_SERVER['PHP_SELF']);

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permitir los métodos que usas en tu API
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
// Permitir los headers personalizados
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Manejar solicitudes OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/TaskController.php';
require_once __DIR__ . '/../utils/Response.php';

try {
    $db = (new Database())->connect();
    $userController = new UserController($db);
    $taskController = new TaskController($db);

    $method = $_SERVER['REQUEST_METHOD'];
    $request = $_SERVER['REQUEST_URI'];
    
    // Obtener el endpoint y el ID si existe
    $path = parse_url($request, PHP_URL_PATH);
    
    // Eliminar la ruta base del proyecto
    $basePath = '/backend-api/public';
    if (strpos($path, $basePath) === 0) {
        $path = substr($path, strlen($basePath));
    }
    
    // Limpiar la ruta
    $path = trim($path, '/');
    $segments = explode('/', $path);
    
    // El primer segmento será el endpoint (users o tasks)
    $endpoint = $segments[0] ?? '';
    // El segundo segmento será el ID si existe
    $id = $segments[1] ?? null;

    // Log para debugging
    error_log("Request Method: " . $method);
    error_log("Path: " . $path);
    error_log("Endpoint: " . $endpoint);
    error_log("ID: " . $id);

    switch ($endpoint) {
        case 'users':
            if ($method === 'GET') {
                $userController->index();
            } elseif ($method === 'POST') {
                $userController->store();
            } else {
                Response::json(["error" => "Método no permitido"], 405);
            }
            break;

        case 'tasks':
            if ($method === 'GET') {
                $taskController->index();
            } elseif ($method === 'POST') {
                $taskController->store();
            } elseif ($method === 'PUT' && $id) {
                $taskController->complete($id);
            } elseif ($method === 'DELETE' && $id) {
                $taskController->delete($id);
            } else {
                Response::json(["error" => "Método no permitido"], 405);
            }
            break;

        default:
            Response::json(["error" => "Endpoint no encontrado: " . $endpoint], 404);
            break;
    }
} catch (Exception $e) {
    error_log("Error en la aplicación: " . $e->getMessage());
    Response::json(["error" => "Error interno del servidor: " . $e->getMessage()], 500);
}
