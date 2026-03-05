<?php
// 1. Ajuste de ruta para la conexión:
// Subimos un nivel (../) porque db.php está en la raíz de 'api/'
require_once '../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolección de datos del formulario
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? ''; 
    $clase = $_POST['clase'] ?? '';
    $fecha_produccion = $_POST['fecha_produccion'] ?? '';
    $fin_soporte = $_POST['fin_soporte'] ?? '';
    $especificaciones = $_POST['especificaciones'] ?? '';

    try {
        $sql = "INSERT INTO modelos (Marca, Modelo, Categoria, Fecha_produccion, Fin_soporte, Especificaciones) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$marca, $modelo, $clase, $fecha_produccion, $fin_soporte, $especificaciones]);

        // 2. Ajuste de redirección de éxito:
        // Tu archivo visual 'modelos.php' está en la raíz del proyecto.
        // Desde 'api/modelos/' hay que subir DOS niveles (../../)
        header("Location: ../../modelos.php");
        exit();

    } catch (PDOException $e) {
        // 3. Ajuste de redirección de error:
        // Subimos dos niveles para llegar a la raíz donde está 'modelos.php'
        header("Location: ../../modelos.php");
        exit();
    }
}
?>