<?php
require_once __DIR__ . '/db.php';

/**
 * Valida que la tabla y el campo existan en el esquema de la base de datos
 * para prevenir Inyección SQL en identificadores.
 */
function validarEstructuraDB($tabla, $campo = null) {
    // Definición exacta basada en tu MainQuery.sql
    $esquema = [
        "modelos" => [
            "ID_Modelo", "Marca", "Modelo", "Categoria", 
            "Fecha_produccion", "Fin_soporte", "Especificaciones"
        ],
        "activos" => [
            "ID_Activo", "N_Serial", "ID_Modelo", "Estado", 
            "Nombre", "Fecha_compra", "Garantia", "Modificado", "Observaciones"
        ],
        "asignaciones" => [
            "ID_Asignacion", "ID_empleado", "Fecha_Asignacion", "Ultimo_Soporte", "ID_Activo"
        ]
    ];

    if (!array_key_exists($tabla, $esquema)) {
        return false;
    }

    if ($campo !== null && !in_array($campo, $esquema[$tabla])) {
        return false;
    }

    return true;
}

// obtenerRegistroPorId: obtiene un elemento por su id en una tabla especifica 
function obtenerRegistroPorId($tabla, $id) {
    global $pdo;

    // Mapeo automático de llaves primarias según tu SQL
    $pks = [
        "modelos" => "ID_Modelo",
        "activos" => "ID_Activo",
        "asignaciones" => "ID_Asignacion"
    ];

    if (!array_key_exists($tabla, $pks)) return null;

    $campoId = $pks[$tabla];
    
    $stmt = $pdo->prepare("SELECT * FROM `$tabla` WHERE `$campoId` = ?");
    $stmt->execute([$id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

// obtenerRegistroPorCampo: obtiene un elemento segun el valor de un campo especificado.
function obtenerRegistroPorCampo($tabla, $campo, $valor) {
    global $pdo;

    if (!validarEstructuraDB($tabla, $campo)) return null;

    $stmt = $pdo->prepare("SELECT * FROM `$tabla` WHERE `$campo` = ? LIMIT 1");
    $stmt->execute([$valor]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
// obtenerListaPorCampo: obtiene un elemento segun el valor de un campo especificado.
function obtenerListaPorCampo($tabla, $campo, $valor) {
    global $pdo;

    if (!validarEstructuraDB($tabla, $campo)) return [];

    $stmt = $pdo->prepare("SELECT * FROM `$tabla` WHERE `$campo` = ?");
    $stmt->execute([$valor]);
    
    // Retornamos array vacío si no hay resultados para facilitar el uso de foreach
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
}
?>