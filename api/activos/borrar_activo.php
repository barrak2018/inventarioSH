<?php
require_once __DIR__ . '/../db.php'; //

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM activos WHERE ID_Activo = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Redirigir de vuelta con un mensaje de éxito
        header("Location: ../../activos.php?status=success");
        exit();
    } catch (PDOException $e) {
        header("Location: ../../activos.php?status=error");
        exit();
    }
}