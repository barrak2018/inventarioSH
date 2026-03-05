<?php
require_once __DIR__ . '/../db.php';

try {
    // 1. Definir la consulta SQL
    $sql = "SELECT * FROM asignaciones ORDER BY ID_Asignacion DESC";
    
    // 2. Ejecutar
    $stmt = $pdo->query($sql);
    
    // 3. Obtener los resultados
    $lista_asignaciones = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error al leer modelos: " . $e->getMessage();
    $lista_asignaciones = []; // Array vacío para evitar errores en el HTML
}