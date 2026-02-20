<?php include("./templates/header.php");
require_once './api/modelos/leer_modelos.php';
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
                                    <?php $label = $modelo['ID_Modelo']. "   " . $modelo['Marca']. "   " . $modelo['Modelo'] ?>
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
    
</div>

<?php include("./templates/footer.php"); ?>