<?php 
require_once './api/modelos/leer_modelos.php';
include("./templates/header.php"); 
?>







<div class="col-md-12 mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title border-left border-primary pl-3 mb-4" style="border-width: 5px !important;">
                Registro Modelos
            </h5>

            <form action="./api/modelos/crear_modelo.php" method="POST">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Marca</label>
                        <input type="text" name="marca" class="form-control form-control-sm" placeholder="Ej: Dell" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Modelo</label>
                        <input type="text" name="modelo" class="form-control form-control-sm" placeholder="Ej: Latitude 5420" required>
                    </div>

                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Clase</label>
                        <select name="clase" class="form-control form-control-sm">
                            <option value="Laptop">Laptop</option>
                            <option value="Servidor">Servidor</option>
                            <option value="Desktop">Desktop</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                      <label class="font-weight-bold small">Año Producción</label>
                      <input type="number" name="fecha_produccion" class="form-control form-control-sm" min="1900" max="2100" value="2025">
                    </div>

                    <div class="col-md-2 form-group">
                      <label class="font-weight-bold small">Fin del Soporte</label>
                      <input type="date" name="fin_soporte" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold small">Especificaciones Técnicas</label>
                        <textarea name="especificaciones" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Registrar Modelo</button>
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
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Clase</th>
                        <th>Año</th>
                        <th>Fin Soporte</th>
                        <th>Especificaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lista_modelos)): ?>
                        <?php foreach ($lista_modelos as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['ID_Modelo']) ?></td>
                                <td><?= htmlspecialchars($row['Marca']) ?></td>
                                <td><?= htmlspecialchars($row['Modelo']) ?></td>
                                <td><?= htmlspecialchars($row['Categoria']) ?></td>
                                <td><?= htmlspecialchars($row['Fecha_produccion']) ?></td>
                                <td><?= htmlspecialchars($row['Fin_soporte']) ?></td>
                                <td class="small"><?= htmlspecialchars($row['Especificaciones']) ?></td>
                                <td>

                                    <a href="./api/modelos/borrar_modelo.php?id=<?= $row['ID_Modelo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar el modelo: <?= htmlspecialchars($row['Modelo']) ?>?')">Borrar</a>


                                    <a href="./utils/item_info_modelo.php?id=<?= $row['ID_Modelo'] ?>" class="btn btn-secondary btn-sm" >Info</a>

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


