<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioAsignacion">
        <input type="hidden" name="asignacion_id" id="asignacion_id">
        <div class="row mb-3">
            <div class="col">
                <label for="asignacion_alumno">ALUMNO</label>
                <select name="asignacion_alumno" id="asignacion_alumno" class="form-control">
                    <option value="">SELECCIONE...</option>
                    <?php foreach ($alumnos as $alumno) : ?>
                        <option value="<?= $alumno['alumno_id'] ?>">
                            <?= $alumno['alumno_nombre'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="asignacion_grado">GRADO</label>
                <select name="asignacion_grado" id="asignacion_grado" class="form-control">
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
                <label for="asignacion_seccion">SECCION</label>
                <select name="asignacion_seccion" id="asignacion_seccion" class="form-control">
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
                <label for="asignacion_profesor">PROFESOR</label>
                <select name="asignacion_profesor" id="asignacion_profesor" class="form-control">
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
                <button type="submit" form="formularioAsignacion" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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
        <table id="tablaAsignaciones" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/asignaciones/index.js') ?>"></script>