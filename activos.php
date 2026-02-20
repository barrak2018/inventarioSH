<?php include("./templates/header.php");
require_once './api/modelos/leer_modelos.php';
require_once './api/activos/leer_activos.php';
require_once './api/activos/crear_activo.php';
?>

<div class="col-md-12 mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title border-left border-primary pl-3 mb-4" style="border-width: 5px !important;">
                Registro de Activo Físico
            </h5>

            <form action="./api/activos/crear_activo.php" method="POST">
                <div class="row">
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Nombre del Activo</label>
                        <input type="text" name="nombre" class="form-control form-control-sm" placeholder="Ej: LAPTOP-ADMIN-01">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Número de Serial</label>
                        <input type="text" name="serial" class="form-control form-control-sm" placeholder="S/N Único">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Modelo Relacionado</label>
                        <select name="modelo" class="form-control form-control-sm">
                            <?php if (!empty($lista_modelos)):?>
                                <?php foreach ($lista_modelos as $modelo): ?>
                                    <?php $label = $modelo['ID_Modelo']. "#: " . $modelo['Marca']. "   " . $modelo['Modelo'] ?>
                                    <option value="<?=htmlspecialchars($modelo['ID_Modelo'])?>"><?= htmlspecialchars($label) ?></option>
                                <?php endforeach?>
                            <?php else: ?>
                                    <option value="unknow" disabled>No hay Modelos Disponibles</option>
                            <?php endif; ?>
                            
                            </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Estado</label>
                        <select name="estado" class="form-control form-control-sm">
                            <option value="disponible">Disponible</option>
                            <option value="asignado">Asignado</option>
                            <option value="mantenimiento">En Mantenimiento</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Fecha de Compra</label>
                        <input type="date" name="fecha_compra" class="form-control form-control-sm">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">Vencimiento Garantía</label>
                        <input type="date" name="vencimiento" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 form-group">
                        <label class="font-weight-bold small">¿Modificado?</label>
                        <select name="modificado" class="form-control form-control-sm">
                            <option value="no">No (Original)</option>
                            <option value="si">Sí</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="font-weight-bold small">Observaciones</label>
                        <textarea name="observaciones" class="form-control form-control-sm" rows="2"></textarea>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm px-4">Registrar Activo</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shado-sm">
      
      <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>estado</th>
                    <th>Observaciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($lista_activos)):?>
                    <?php foreach($lista_activos as $row): ?>
                        <?php
                            foreach ($lista_modelos as $item) {
                                if ($item['ID_Modelo'] === $row['ID_Modelo']) {
                                    $Nombre_Modelo = $item['Modelo'];
                                }
                            }
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($row['ID_Activo']) ?></td>
                            <td><?= htmlspecialchars($row['Nombre']) ?></td>
                            <td><?= htmlspecialchars($Nombre_Modelo) ?></td>
                            <td><?= htmlspecialchars($row['Estado']) ?></td>
                            <td class="small" ><?= htmlspecialchars($row['Observaciones']) ?></td>
                            <td>
                                <a href="./api/activos/borrar_activo.php?id=<?= $row['ID_Activo'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar el Activo: <?= htmlspecialchars($row['Nombre']) ?>?')">Borrar</a>
                                <button class="btn btn-secondary btn-sm">Editar</button>
                            </td>
                        </tr>
                    <?php endforeach?>
                <?php else:?>
                    <tr>
                        <td colspan="6" class="text-center">No hay datos registrados</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
      </div>
    </div>
    
</div>

<?php include("./templates/depfooter.php"); ?>