<h1 class="text-center">Registro de Asistencia</h1>
<div class="container">
    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border bg-light p-3" id="formularioAsistencia">
            <input type="hidden" name="asistencia_id" id="asistencia_id">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alumno_id">Alumno</label>
                    <select name="alumno_id" id="alumno_id" class="form-control">
                        <option value="">SELECCIONE...</option>
                        <?php foreach ($alumnos as $alumno) : ?>
                            <option value="<?= $alumno['alumno_id'] ?>">
                                <?= $alumno['alumno_nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="asistencia_fecha">Fecha de Asistencia</label>
                    <input type="date" name="asistencia_fecha" id="asistencia_fecha" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="asistencia_asistio">Asistencia</label>
                    <select name="asistencia_asistio" id="asistencia_asistio" class="form-control">
                        <option value="presente">Presente</option>
                        <option value="ausente">Ausente</option>
                    </select>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <button type="submit" form="formularioAsistencia" id="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
                </div>
                <div class="col">
                    <button type="button" id="btnModificar" class="btn btn-warning btn-block">Modificar</button>
                </div>
                <div class="col">
                    <button type="button" id="btnBuscar" class="btn btn-info btn-block">Buscar</button>
                </div>
                <div class="col">
                    <button type="button" id="btnCancelar" class="btn btn-danger btn-block">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
    <h1>Datatable de Asistencia</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaAsistencia" class="table table-bordered table-hover">
                <!-- Contenido de la tabla aquí -->
            </table>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/asistencia/index.js') ?>"></script>
