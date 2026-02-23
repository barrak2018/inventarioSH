<?php 
require_once './api/activos/leer_activos.php';
require_once './api/asignaciones/leer_asignacion.php';
require_once './api/db.php';
include("./templates/header.php"); 
?>



<?php
    
?>



<div class="col-md-12 mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title border-left border-primary pl-3 mb-4" style="border-width: 5px !important;">
                Registro de Asignaciones
            </h5>

            <form action="./api/asignaciones/crear_asignacion.php" method="POST">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Identificador</label>
                        <input type="text" name="Identificador" class="form-control form-control-sm"  required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Fecha de Asignacion</label>
                        <input type="date" name="Fecha_Asignacion" class="form-control form-control-sm" required>
                    </div>

                    <div class="col-md-2 form-group">
                      <label class="font-weight-bold small">Ultimo Soporte</label>
                      <input type="date" name="Ultimo_soporte" class="form-control form-control-sm">
                    </div>

                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Activo Asignado</label>
                        <select name="ID_Activo" class="form-control form-control-sm">
                            <?php foreach($lista_activos as $item):?>
                                <?php if ($item['Estado'] === "Disponible"):?>
                                <option value="<?=$item['ID_Activo']?>"><?=$item['ID_Activo'] .' # ' . $item['Nombre']. ' S/N: '. $item['N_Serial'] ?></option>
                                <?php endif?>
                            <?php endforeach;?>
                        </select>
                    </div>

                </div>

                

                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Registrar Asignacion</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Identificador</th>
                        <th>Fecha de Asignacion</th>
                        <th>Fecha del ultimo soporte</th>
                        <th>Activo Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lista_asignaciones)): ?>
                        <?php foreach ($lista_asignaciones as $row): ?>
                            <?php
                                foreach ($lista_activos as $item) {
                                    if ($item['Estado'] === "Disponible") {
                                        $activo = $item["Nombre"] . "  S/N: " . $item['N_Serial'];
                                    }
                                    
                                }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['ID_Asignacion']) ?></td>
                                <td><?= htmlspecialchars($row['Identificador']) ?></td>
                                <td><?= htmlspecialchars($row['Fecha_Asignacion']) ?></td>
                                <td><?= htmlspecialchars($row['Ultimo_Soporte'])?></td>
                                <td><?= htmlspecialchars($activo)?></td>
                                
                                <td>

                                    <a href="./api/asignaciones/borrar_asignacion.php?id=<?= $row['ID_Asignacion'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar la asignacion de: <?= htmlspecialchars($row['Identificador']) ?>?')">Borrar</a>


                                    <a href="./utils/item_info_modelo.php?id=<?= $row['ID_Asignacion'] ?>" class="btn btn-secondary btn-sm" >Info</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No hay datos registrados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div> 
</div> 

<?php if (isset($_GET['status'])): ?>
<script>
    // 1. Mostrar la alerta según el caso
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        alert("¡Éxito! La operación se realizó correctamente.");
    <?php endif; ?>

    <?php if (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
        alert("¡Error! No se pudo eliminar el registro.");
    <?php endif; ?>

    // 2. Limpiar la URL sin recargar
    // if (window.history.replaceState) {
    //     // Obtenemos la URL actual sin los parámetros (la parte antes del '?')
    //     var clean_url = window.location.protocol + "//" + window.location.host + window.location.pathname;
    //     window.history.replaceState({path: clean_url}, '', clean_url);
    // }
</script>
<?php endif; ?>



<?php include("./templates/footer.php"); ?>


