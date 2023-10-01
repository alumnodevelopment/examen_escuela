<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioActividad">
        <input type="hidden" name="actividad_id" id="actividad_id">
        <div class="row mb-3">
            <div class="col">
                <label for="actividad_profesor">PROFESOR</label>
                <select name="actividad_profesor" id="actividad_profesor" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($profesores as $profesor) : ?>
                        <option value="<?= $profesor['profesor_id'] ?>">
                            <?= $profesor['profesor_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="actividad_grado">GRADO</label>
                <select name="actividad_grado" id="actividad_grado" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($grados as $grado) : ?>
                        <option value="<?= $grado['grado_id'] ?>">
                            <?= $grado['grado_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="actividad_seccion">SECCION</label>
                <select name="actividad_seccion" id="actividad_seccion" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($secciones as $seccion) : ?>
                        <option value="<?= $seccion['seccion_id'] ?>">
                            <?= $seccion['seccion_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="actividad_fecha_inicio">FECHA Y HORA DE INICIO</label>
                <input type="datetime-local" name="actividad_fecha_inicio" id="actividad_fecha_inicio" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="actividad_fecha_fin">FECHA Y HORA DE FINALIZACIÓN</label>
                <input type="datetime-local" name="actividad_fecha_fin" id="actividad_fecha_fin" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="actividad_descripcion">DESCRIPCIÓN DE LA ACTIVIDAD</label>
                <input type="text" name="actividad_descripcion" id="actividad_descripcion" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioActividad" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button type="button" id="btnModificar" class="btn btn-warning w-100">Modificar</button>
            </div>
            <div class="col">
                <button type="button" id="btnBuscar" class="btn btn-info w-100">Buscar</button>
            </div>
            <div class="col">
                <button type="button" id="btnCancelar" class="btn btn-danger w-100">Cancelar</button>
            </div>
        </div>

    </form>
</div>

<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaActividades" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/actividades/index.js') ?>"></script>