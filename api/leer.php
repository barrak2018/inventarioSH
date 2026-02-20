<?php
require_once __DIR__ . '/db.php';

function obtenerRegistroPorId($tabla, $id) {
    global $pdo; // IMPORTANTE: Sin esto, $pdo es null dentro de la función

    $map = [
        "modelos" => "ID_Modelo",
        "activos" => "ID_Activo",
        "asignacion" => "ID_Asignacion"
    ];

    if (!array_key_exists($tabla, $map)) return null;

    $sp_id = $map[$tabla];
    
    // Usamos el objeto $pdo global
    $stmt = $pdo->prepare("SELECT * FROM $tabla WHERE $sp_id = ?");
    $stmt->execute([$id]);
    
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado ? $resultado : null; // Retorna null si no hay registro
}
?>