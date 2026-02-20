<?php
require_once __DIR__ . './db.php';


// En un archivo llamado funciones_db.php
function obtenerRegistroPorId($pdo, $tabla, $id) {
    $map = [
        "modelos" => "ID_Modelo",
        "activos" => "ID_Activo",
        "asignacion" => "ID_Asignacion"
    ];

    if (!array_key_exists($tabla, $map)) return null;

    $sp_id = $map[$tabla];
    $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE $sp_id = ?");
    $stmt->execute([$id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>