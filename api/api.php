<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require_once __DIR__ . '/crud.php';

// 1. Capturar el método y la ruta
$metodo = $_SERVER['REQUEST_METHOD'];
$resource = isset($_GET['resource']) ? $_GET['resource'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Manejo de peticiones OPTIONS (Preflight para CORS)
if ($metodo == 'OPTIONS') {
    http_response_code(200);
    exit;
}

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
        $resultado = obtenerRegistroPorId($resource, $id);
    } else {
        enviarRespuesta(400, ["error" => "ID requerido para esta consulta"]);
        return;
    }

    $resultado ? enviarRespuesta(200, $resultado) : enviarRespuesta(404, ["error" => "No encontrado"]);
}

/**
 * Lógica para CREAR registros
 */
function procesarPost($resource) {
    if (!$resource) {
        enviarRespuesta(400, ["error" => "Recurso no especificado para la creación"]);
    }

    // Leer el cuerpo de la petición (JSON)
    $json = file_get_contents('php://input');
    $datos = json_decode($json, true); // Convertir a array asociativo

    if (!$datos || !is_array($datos)) {
        enviarRespuesta(400, ["error" => "Datos JSON inválidos o vacíos"]);
    }

    // Llamar a la función del archivo crud.php
    $nuevoId = crearRegistro($resource, $datos);

    if ($nuevoId) {
        enviarRespuesta(201, [
            "mensaje" => "Registro creado con éxito en $resource",
            "id" => $nuevoId
        ]);
    } else {
        enviarRespuesta(500, ["error" => "No se pudo crear el registro. Verifique la estructura de los datos."]);
    }
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