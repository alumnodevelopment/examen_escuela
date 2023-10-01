<h1 class="text-center">Registro de Asistencia</h1>
<div class="container">
    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border bg-light p-3" id="formularioAsistencia">
            <input type="hidden" name="asistencia_id" id="asistencia_id">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="asistencia_fecha">Fecha de Asistencia</label>
                    <input type="date" name="asistencia_fecha" id="asistencia_fecha" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="grado_id">Grado</label>
                    <select name="grado_id" id="grado_id" class="form-control" required>
                        <option value="">SELECCIONE...</option>
                        <?php foreach ($grados as $grado) : ?>
                            <option value="<?= $grado['grado_id'] ?>">
                                <?= $grado['grado_nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="seccion_id">Sección</label>
                    <select name="seccion_id" id="seccion_id" class="form-control" required>
                        <option value="">SELECCIONE...</option>
                        <?php foreach ($secciones as $seccion) : ?>
                            <option value="<?= $seccion['seccion_id'] ?>">
                                <?= $seccion['seccion_nombre'] ?></option>
                        <?php endforeach ?>
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
