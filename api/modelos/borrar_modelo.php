<?php
require_once __DIR__ . '/../db.php'; //

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM modelos WHERE ID_Modelo = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Redirigir de vuelta con un mensaje de éxito
        header("Location: ../../modelos.php?status=success");
        exit();
    } catch (PDOException $e) {
        header("Location: ../../modelos.php?status=error");
        exit();
    }
}