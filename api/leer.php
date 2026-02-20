<?php
require_once './db.php';

if (isset($_GET['id']) && isset($_GET["tabla"])) {
    $id = $_GET['id'];
    $tabla = $_GET["tabla"];
    $sp_id = "";

    // Whitelist validation for table and column names
    if ($tabla === "modelos") {
        $sp_id = "ID_Modelo";
    } elseif ($tabla === "activos") {
        $sp_id = "ID_Activo";
    } elseif ($tabla === "asignacion") {
        $sp_id = "ID_Asignacion";
    }

    // Only proceed if a valid table was matched
    if ($sp_id !== "") {
        try {
            // Note: Table and Column names are injected directly, 
            // only the VALUE ($id) uses a placeholder.
            $sql = "SELECT * FROM $tabla WHERE $sp_id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);

            $target = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // fetch() returns an array or false, echo cannot print an array.
            if ($target) {
                echo json_encode($target); 
            } else {
                
            }

        } catch (\Throwable $th) {
            echo "Error en la consulta: " . $th->getMessage();
        }
    } else {
        echo "Tabla no permitida.";
    }
} else {
    echo "Faltan parámetros (id o tabla).";
}
?>