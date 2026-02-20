<?php
require_once __DIR__ . '/../api/leer.php'; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Modelo</title>
    <link rel="stylesheet" href="./../css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <?php 
            if(isset($_GET['id'])): 
                $item = obtenerRegistroPorId("modelos", $_GET['id']);
                
                if($item): 
            ?>
                <div class="col-md-8 mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Información del Modelo</h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title text-uppercase">
                                <?= htmlspecialchars($item['Marca'] . " " . $item['Modelo']) ?>
                            </h3>
                            <hr>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><strong>ID Modelo:</strong> <?= htmlspecialchars($item['ID_Modelo']) ?></p>
                                    <p><strong>Categoría:</strong> <?= htmlspecialchars($item['Categoria']) ?></p>
                                    <p><strong>Año de Producción:</strong> <?= htmlspecialchars($item['Fecha_produccion']) ?></p>
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Fin de Soporte:</strong> 
                                        <span class="badge bg-info text-dark"><?= htmlspecialchars($item['Fin_soporte']) ?></span>
                                    </p>
                                    <p><strong>Especificaciones:</strong><br>
                                        <small class="text-muted"><?= nl2br(htmlspecialchars($item['Especificaciones'])) ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="./../modelos.php" class="btn btn-secondary btn-sm">Volver al listado</a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-6 mt-5">
                    <div class="alert alert-danger shadow-sm text-center">
                        <strong>Error:</strong> El modelo con ID <?= htmlspecialchars($_GET['id']) ?> no existe en la base de datos.
                    </div>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>