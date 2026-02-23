<?php
require_once __DIR__ . '/../db.php'; //

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM asignaciones WHERE ID_Asignacion = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Redirigir de vuelta con un mensaje de éxito
        header("Location: ../../asignaciones.php?status=success");
        exit();
    } catch (PDOException $e) {
        header("Location: ../../asignaciones.php?status=error");
        exit();
    }
}