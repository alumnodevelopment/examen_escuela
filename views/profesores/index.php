<h1 class="text-center">FORMULARIO PARA INGRESAR PROFESORES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioProfesor">
        <input type="hidden" name="profesor_id" id="profesor_id">
        <div class="row mb-3">
            <div class="col">
                <label for="profesor_nombre">Nombre del Profesor</label>
                <input type="text" name="profesor_nombre" id="profesor_nombre" class="form-control">
            </div>
            <div class="col">
                <label for="profesor_telefono">Teléfono</label>
                <input type="text" name="profesor_telefono" id="profesor_telefono" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioProfesor" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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

<h1>Datatable de profesores</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaProfesor" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/profesores/index.js') ?>"></script>
