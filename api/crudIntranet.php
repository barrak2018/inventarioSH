<?php
/**
 * CRUD de Solo Lectura para intranetDB
 * Sincronizado con la variable $pdo_int de config.php
 */
require_once __DIR__ . '/config.php';

/**
 * Validación estricta de tablas y columnas permitidas.
 */
function validarLecturaIntranet($tabla, $campo = null) {
    $esquema = [
        "datos_empleado" => [
            "id_empleado", "codigo_nomina", "fecha_ingreso", "id_cargo", 
            "id_departamento", "id_ubicacion", "extension", "estatus"
        ],
        "datos_personales" => [
            "id_personal", "id_empleado", "nombres", "apellidos", 
            "cedula", "fecha_nacimiento", "genero", "correo_personal", "telefono"
        ]
    ];

    if (!array_key_exists($tabla, $esquema)) return false;
    if ($campo !== null && !in_array($campo, $esquema[$tabla])) return false;
    return true;
}

/**
 * Obtiene todos los registros de la tabla especificada (Solo lectura)
 */
function obtenerTodoIntranet($tabla) {
    global $pdo_int; // Corregido: Coincide con config.php
    
    if (!validarLecturaIntranet($tabla)) {
        return ["error" => "Tabla no permitida o inexistente"];
    }
    
    try {
        // Usamos $pdo_int para la consulta
        $stmt = $pdo_int->query("SELECT * FROM `$tabla` ORDER BY 1 DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return ["error" => "Error de consulta: " . $e->getMessage()];
    }
}

/**
 * Obtiene un registro específico por ID
 */
function obtenerPorIdIntranet($tabla, $id) {
    global $pdo_int; // Corregido: Coincide con config.php
    
    $pks = [
        "datos_empleado" => "cod_datos",
        "datos_personales" => "cod_datos"
    ];

    if (!validarLecturaIntranet($tabla)) return null;
    $campoId = $pks[$tabla];

    try {
        $stmt = $pdo_int->prepare("SELECT * FROM `$tabla` WHERE `$campoId` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Consulta combinada (JOIN) para ver la ficha completa usando $pdo_int
 */
function obtenerFichaEmpleado($cedula) {
    global $pdo_int; // Corregido: Coincide con config.php
    
    $sql = "SELECT e.*, p.nombres, p.apellidos, p.cedula 
            FROM datos_personales p
            INNER JOIN datos_empleado e ON p.cod_datos = e.cod_datos
            WHERE p.cedula = ?";
    
    try {
        $stmt = $pdo_int->prepare($sql);
        $stmt->execute([$cedula]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return null;
    }
}


