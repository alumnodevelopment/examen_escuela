<h1 class="text-center">Registro de alumnos</h1>
    <div class="container">
        <div class="row justify-content-center mb-5">
            <form class="col-lg-8 border bg-light p-3" id="formularioAlumnos" accept-charset="UTF-8">
                <input type="hidden" name="alumno_id" id="alumno_id">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alumno_nombre">Nombre del alumno</label>
                        <input type="text" name="alumno_nombre" id="alumno_nombre" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label for="alumno_edad">Edad del alumno</label>
                        <input type="number" name="alumno_edad" id="alumno_edad" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alumno_sexo">Género del alumno</label>
                        <select name="alumno_sexo" id="alumno_sexo" class="form-control">
                            <option value="">Todos</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="alumno_fecha_nacimiento">Fecha de nacimiento del alumno</label>
                        <input type="date" name="alumno_fecha_nacimiento" id="alumno_fecha_nacimiento" class="form-control">
                    </div>
                </div>
                <div class="row ">
                    <div class="col">
                        <button type="submit" form="formularioAlumnos" id="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
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
        <h1>Historial de Alumnos</h1>
        <div class="row justify-content-center">
            <div class="col table-responsive">
                <table id="tablaAlumnos" class="table table-bordered table-hover">
                    <!-- Contenido de la tabla aquí -->
                </table>
            </div>
        </div>
    </div>
    <script src="<?= asset('./build/js/alumnos/index.js') ?>"></script>
