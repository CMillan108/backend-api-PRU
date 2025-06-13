<?php
/**
 * Clase Response
 * 
 * Proporciona métodos para manejar las respuestas HTTP de la API.
 * Encapsula la lógica de envío de respuestas JSON con códigos de estado apropiados.
 */
class Response {
    /**
     * Envía una respuesta JSON con el código de estado HTTP especificado
     * 
     * @param mixed $data Datos a enviar en la respuesta
     * @param int $status Código de estado HTTP (por defecto 200)
     * @return void
     */
    public static function json($data, $status = 200) {
        http_response_code($status);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}
