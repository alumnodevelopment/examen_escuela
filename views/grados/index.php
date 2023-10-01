<h1 class="text-center">GRADOS</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioGrado">
        <input type="hidden" name="grado_id" id="grado_id">
        <div class="row mb-3">
                <div class="col">
                    <label for="grado_nombre">Nombre del grado</label>
                    <input type="text" name="grado_nombre" id="grado_nombre" class="form-control">
                </div>
            </div>

            <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioGrado" id="btnGuardar"  class="btn btn-primary w-100">Guardar</button>
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


<!-- <h1>Listado de Empleados</h1> -->
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaGrados" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/grados/index.js') ?>"></script>