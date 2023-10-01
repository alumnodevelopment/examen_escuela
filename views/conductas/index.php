<h1 class="text-center">Registro de Conducta de los Alumnos</h1>
<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form class="border bg-light p-3" id="formularioConducta">
                <div class="mb-3">                        
                        <input type="hidden" name="conducta_id" id="conducta_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="alumno_id" class="form-label">Seleccione un alumno:</label>
                        <select name="alumno_id" id="alumno_id" class="form-select">
                            <option value="">Seleccione un alumno</option>
                            <?php foreach ($alumnos as $alumno) { ?>
                                <option value="<?= $alumno['alumno_id'] ?>"><?= $alumno['alumno_nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="conducta_fecha" class="form-label">Fecha de registro de la conducta:</label>
                        <input type="date" name="conducta_fecha" id="conducta_fecha" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="conducta_descripcion" class="form-label">Descripción de Conducta del alumno:</label>
                        <textarea name="conducta_descripcion" id="conducta_descripcion" class="form-control"></textarea>
                    </div>
            <div class="row ">
                <div class="col">
                    <button type="submit" form="formularioConducta" id="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
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
    <h1>Historial de Conducta de los alumnos</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaConducta" class="table table-bordered table-hover">
                <!-- Contenido de la tabla aquí -->
            </table>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/conductas/index.js') ?>"></script> 