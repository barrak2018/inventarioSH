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
                        <select name="ID_Activo" class="form-control form-control-sm" required>
                            <?php if (!empty($lista_activos)): ?>
                                <?php 
                                $hay_disponibles = false;
                                foreach($lista_activos as $item): 
                                    // Usamos trim() para evitar errores por espacios en blanco y strcasecmp para ignorar mayúsculas
                                    if (isset($item['Estado']) && trim($item['Estado']) === "disponible"): 
                                        $hay_disponibles = true;
                                ?>
                                    <option value="<?= htmlspecialchars($item['ID_Activo']) ?>">
                                        <?= htmlspecialchars($item['ID_Activo'] . ' # ' . $item['Nombre'] . ' S/N: ' . $item['N_Serial']) ?>
                                    </option>
                                <?php 
                                    endif;
                                endforeach; 

                                if (!$hay_disponibles): ?>
                                    <option value="" disabled selected>No hay activos con estado 'Disponible'</option>
                                <?php endif; ?>

                            <?php else: ?>
                                <option value="" disabled selected>No se encontraron activos en la base de datos</option>
                            <?php endif; ?>
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
                                // Buscamos el activo que corresponde a esta asignación específica
                                $activo_nombre = "No encontrado"; 
                                foreach ($lista_activos as $item) {
                                    if ($item['ID_Activo'] == $row['ID_Activo']) { // Suponiendo que tu tabla asignaciones tiene ID_Activo
                                        $activo_nombre = $item["Nombre"] . " S/N: " . $item['N_Serial'];
                                        break; // Salimos del bucle una vez encontrado
                                    }
                                }
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['ID_Asignacion']) ?></td>
                                <td><?= htmlspecialchars($row['Identificador']) ?></td>
                                <td><?= htmlspecialchars($row['Fecha_Asignacion']) ?></td>
                                <td><?= htmlspecialchars($row['Ultimo_Soporte'])?></td>
                                <td><?= htmlspecialchars($activo_nombre)?></td>
                                <td>
                                    <a href="./api/asignaciones/borrar_asignacion.php?id=<?= $row['ID_Asignacion'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas la asignacion a: <?= htmlspecialchars($row['Identificador']) ?>?')">Borrar</a>
                                    <button class="btn btn-secondary btn-sm">Editar</button>
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


