<?php
// 1. Ajuste de ruta para la conexión:
// Subimos un nivel (../) porque db.php está en la raíz de 'api/'
require_once __DIR__ . '/../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolección de datos del formulario
    $Identificador = $_POST['Identificador'] ?? '';
    $Fecha_Asignacion = $_POST['Fecha_Asignacion'] ?? ''; 
    $Ultimo_Soporte = $_POST['Ultimo_Soporte'] ?? '';
    $ID_Activo = $_POST['ID_Activo'] ?? '';

    

    if (isset($ID_Activo)) {
    
        try {
            $sql = "INSERT INTO asignaciones (
                Identificador,
                Fecha_Asignacion,
                Ultimo_Soporte,
                ID_Activo
                ) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $Identificador,
                $Fecha_Asignacion,
                $Ultimo_Soporte,
                $ID_Activo
            ]);

            // 2. Ajuste de redirección de éxito:
            // Tu archivo visual 'activos.php' está en la raíz del proyecto.
            // Desde 'api/modelos/' hay que subir DOS niveles (../../)
            header("Location: ../../asignaciones.php");
            exit();

        } catch (PDOException $e) {
            // 3. Ajuste de redirección de error:
            // Subimos dos niveles para llegar a la raíz donde está 'activos.php'
            $error = urlencode($e->getMessage());
            header("Location: ../../asignaciones.php?status=error&msg=$error");
            exit();
        }
    }
    else{
        header("Location: ../../asignaciones.php?status=formerror");
    }
}
?>