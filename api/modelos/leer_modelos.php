<?php
require_once __DIR__ . '/../db.php';

try {
    // 1. Definir la consulta SQL
    $sql = "SELECT * FROM modelos ORDER BY ID_Modelo DESC";
    
    // 2. Ejecutar
    $stmt = $pdo->query($sql);
    
    // 3. Obtener los resultados
    $lista_modelos = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error al leer modelos: " . $e->getMessage();
    $lista_modelos = []; // Array vacío para evitar errores en el HTML
}