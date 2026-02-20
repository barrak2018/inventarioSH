<?php
// 1. Ajuste de ruta para la conexión:
// Subimos un nivel (../) porque db.php está en la raíz de 'api/'
require_once __DIR__ . '/../db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recolección de datos del formulario
    $N_Serial = $_POST['serial'] ?? '';
    $ID_Modelo = $_POST['modelo'] ?? ''; 
    $Estado = $_POST['estado'] ?? '';
    $Nombre = $_POST['nombre'] ?? '';
    $Fecha_compra = $_POST['fecha_compra'] ?? '';
    $Garantia = $_POST['vencimiento'] ?? '';
    $Modificado = $_POST['modificado'] ?? '';
    $Observaciones = $_POST['observaciones'] ?? '';




    if ($ID_Modelo != "unknon") {
    
        try {
            $sql = "INSERT INTO activos (
                N_serial,
                ID_Modelo,
                Estado,
                Nombre,
                Fecha_compra,
                Garantia,
                Modificado,
                Observaciones
                ) VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $N_Serial,
                $ID_Modelo,
                $Estado,
                $Nombre,
                $Fecha_compra,
                $Garantia,
                $Modificado,
                $Observaciones
            ]);

            // 2. Ajuste de redirección de éxito:
            // Tu archivo visual 'activos.php' está en la raíz del proyecto.
            // Desde 'api/modelos/' hay que subir DOS niveles (../../)
            header("Location: ../../activos.php");
            exit();

        } catch (PDOException $e) {
            // 3. Ajuste de redirección de error:
            // Subimos dos niveles para llegar a la raíz donde está 'activos.php'
            $error = urlencode($e->getMessage());
            header("Location: ../../activos.php?status=error&msg=$error");
            exit();
        }
    }
    else{
        header("Location: ../../activos.php?status=formerror");
    }
}
?>