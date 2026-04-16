<?php
/**
 * Manager de la API para la Intranet (Solo Lectura)
 * Adaptación de inventory_manager.php
 */
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS"); // Solo GET permitido

require_once __DIR__ . '/crudIntranet.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$resource = $_GET['resource'] ?? null;
$id = $_GET['id'] ?? null;

// Manejo de CORS Preflight
if ($metodo == 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Bloquear cualquier método que no sea GET
if ($metodo !== 'GET') {
    enviarRespuestaIntranet(405, ["error" => "Método no permitido. Este recurso es de solo lectura."]);
}

// Validar que se especifique un recurso (tabla)
if (!$resource) {
    enviarRespuestaIntranet(400, ["error" => "Recurso no especificado (Ej: datos_empleados)"]);
}

/**
 * Lógica de la API para consultas
 */
switch ($resource) {
    case 'ficha_empleado':
        // Recurso especial para el JOIN de empleado + datos personales
        if (!$id) {
            enviarRespuestaIntranet(400, ["error" => "ID de empleado requerido para la ficha"]);
        }
        $res = obtenerFichaEmpleado($id);
        $res ? enviarRespuestaIntranet(200, $res) : enviarRespuestaIntranet(404, ["error" => "Empleado no encontrado"]);
        break;

    default:
        // Recursos genéricos (datos_empleados, datos_personales)
        if ($id) {
            $res = obtenerPorIdIntranet($resource, $id);
            $res ? enviarRespuestaIntranet(200, $res) : enviarRespuestaIntranet(404, ["error" => "Registro no encontrado"]);
        } else {
            $res = obtenerTodoIntranet($resource);
            // Si la respuesta es un array con "error", es que la validación falló
            if (isset($res['error'])) {
                enviarRespuestaIntranet(400, $res);
            } else {
                enviarRespuestaIntranet(200, $res);
            }
        }
        break;
}

/**
 * Función auxiliar para enviar respuestas JSON
 */
function enviarRespuestaIntranet($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos);
    exit;
}