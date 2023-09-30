<h1 class="text-center">Registro de Conducta de los Alumnos</h1>
<div class="container">
    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border bg-light p-3" id="formularioConducta"> 
            <input type="hidden" name="conducta_id" id="conducta_id"> 
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="conducta_fecha">Fecha de registro de la conducta</label> 
                    <input type="date" name="conducta_fecha" id="conducta_fecha" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="conducta_descripcion">Descripción de Conducta del alumno</label> 
                    <textarea name="conducta_descripcion" id="conducta_descripcion" class="form-control"></textarea>
                </div>
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
    <h1>Datatable de Conducta</h1>
    <div class="row justify-content-center">
        <div class="col table-responsive">
            <table id="tablaConducta" class="table table-bordered table-hover">
                <!-- Contenido de la tabla aquí -->
            </table>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/conductas/index.js') ?>"></script> 