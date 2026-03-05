<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require_once __DIR__ . '/crud.php';

// 1. Capturar el método y la ruta
$metodo = $_SERVER['REQUEST_METHOD'];
$resource = isset($_GET['resource']) ? $_GET['resource'] : null; // Ejemplo: modelos, activos, asignaciones
$id = isset($_GET['id']) ? $_GET['id'] : null;

// 2. Lógica de enrutamiento
switch ($metodo) {
    case 'GET':
        procesarGet($resource, $id);
        break;

    case 'POST':
        procesarPost($resource);
        break;

    case 'DELETE':
        procesarDelete($resource, $id);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método $metodo no permitido"]);
        break;
}

// --- Funciones de manejo de peticiones ---

function procesarGet($resource, $id) {
    if (!$resource) {
        enviarRespuesta(400, ["error" => "Recurso no especificado"]);
    }

    if ($id) {
        // Ejemplo: GET /api.php?resource=activos&id=5
        $resultado = obtenerRegistroPorId($resource, $id);
    } else {
        // Ejemplo: GET /api.php?resource=activos (Podrías crear una función obtenerTodo en crud.php)
        enviarRespuesta(400, ["error" => "ID requerido para esta consulta"]);
        return;
    }

    $resultado ? enviarRespuesta(200, $resultado) : enviarRespuesta(404, ["error" => "No encontrado"]);
}

function procesarPost($resource) {
    // Leer el cuerpo de la petición (JSON)
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (!$input) {
        enviarRespuesta(400, ["error" => "Datos JSON inválidos"]);
    }

    // Aquí llamarías a una función de inserción que podrías añadir a crud.php
    enviarRespuesta(201, ["mensaje" => "Recurso creado (Simulado)", "data" => $input]);
}

function procesarDelete($resource, $id) {
    if (!$resource || !$id) {
        enviarRespuesta(400, ["error" => "Faltan parámetros para eliminar"]);
    }

    $exito = borrarPorID($resource, $id);
    
    if ($exito) {
        enviarRespuesta(200, ["mensaje" => "Registro $id eliminado de $resource"]);
    } else {
        enviarRespuesta(404, ["error" => "No se pudo eliminar o el registro no existe"]);
    }
}

// Función auxiliar para estandarizar respuestas
function enviarRespuesta($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos);
    exit;
}
?>