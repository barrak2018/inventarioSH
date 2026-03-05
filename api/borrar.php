<?php
require_once './db.php';


// borrarPorID: al resivir un id elimina la entrada de la tabla especificada
function borrarPorID($tabla, $id){
    $pks = [
        "modelos" => "ID_Modelo",
        "activos" => "ID_Activo",
        "asignaciones" => "ID_Asignacion"
    ];
    try {
        $sql = "DELETE FROM ? WHERE ? = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $tabla, 
            $pks[$tabla],
            $id
        ]);

        return true;jl
    } catch (PDOException $e) {
        return false;
    }
};

?>