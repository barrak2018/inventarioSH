<?php
require_once __DIR__ . '/../api/leer.php'; 
require_once __DIR__ . '/../api/asignaciones/leer_asignacion.php';
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
                $item = obtenerRegistroPorId("activos", $_GET['id']);
                
                if($item): 
            ?>
                <?php
                $modelo_asociado = obtenerRegistroPorId('modelos', $item['ID_Modelo']);
                ?>
            
                <div class="col-md-8 mt-4">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Información del Activo</h4>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title text-uppercase">
                                <?= htmlspecialchars($item['Nombre'])?>
                            </h3>
                            <h4 class="text-uppercase">
                                <?= htmlspecialchars($modelo_asociado['Modelo'])?>
                            </h4>
                            <hr>
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><strong>ID Modelo:</strong> 
                                        <?= htmlspecialchars($item['ID_Modelo']) ?>
                                    </p>
                                    <p><strong>Categoría:</strong>
                                        <?= htmlspecialchars($modelo_asociado['Categoria']) ?>
                                    </p>
                                    <p>
                                        <strong>Año de Producción:</strong>
                                        <?= htmlspecialchars($modelo_asociado['Fecha_produccion']) ?>
                                    </p>
                                    <p><strong>Fin de Soporte:</strong> 
                                        <span class="badge bg-info text-dark"><?= htmlspecialchars($modelo_asociado['Fin_soporte']) ?></span>
                                    </p>
                                        <?php if ($item['Modificado']) {
                                            $estado = "Si";
                                        }
                                        else{
                                            $estado = 'No';
                                        } ?>
                                    <p><strong>El equipo ha sido Modificado:</strong> 
                                        <?= htmlspecialchars($estado)?>
                                    </p>

                                    
                                </div>
                                <div class="col-sm-6">
                                    <p><strong>Fecha de Compra:</strong>
                                        <span class="badge badge-info text-dark"><?= htmlspecialchars($item['Fecha_compra']) ?></span>
                                    </p>
                                    <p><strong>Vencimiento de la Garantia:</strong>
                                        <span class="badge badge-info text-dark"><?= htmlspecialchars($item['Garantia']) ?></span>
                                    </p>
                                    
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p><strong>Especificaciones Del Fabricante:</strong><br>
                                        <small class="text-muted"><?= nl2br(htmlspecialchars($modelo_asociado['Especificaciones'])) ?></small>
                                    </p>
                                    <p><strong>Observaciones De la Unidad:</strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($item['Observaciones']) ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="./../activos.php" class="btn btn-secondary btn-sm">Volver al listado</a>
                            <a href="#" class="btn btn-primary btn-sm">Editar</a>
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