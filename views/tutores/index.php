<h1 class="text-center">FORMULARIO PARA INGRESAR TUTORES</h1>
<div class="row justify-content-center mb-5">
    <form class="col-lg-8 border bg-light p-3" id="formularioTutor">
        <input type="hidden" name="tutor_id" id="tutor_id">
        <div class="row mb-3">
            <div class="col">
                <label for="tutor_nombre">Nombre del Tutor</label>
                <input type="text" name="tutor_nombre" id="tutor_nombre" class="form-control">
            </div>
            <div class="col">
                <label for="tutor_telefono">Teléfono</label>
                <input type="text" name="tutor_telefono" id="tutor_telefono" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="tutor_parentezco">Parentezco</label>
                <select name="tutor_parentezco" id="tutor_parentezco" class="form-control">
                    <option value="">Seleccione una opción</option>
                    <option value="TUTOR LEGAL">Tutor Legal</option>
                    <option value="PADRE">Padre</option>
                    <option value="MADRE">Madre</option>
                </select>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="alumno_id">Alumno Relacionado</label>
                    <select name="alumno_id" id="alumno_id" class="form-control">
                        <option value="">Seleccione un alumno</option>
                        <?php foreach ($alumnos as $alumno) : ?>
                            <option value="<?php echo $alumno->alumno_id; ?>"><?php echo $alumno->alumno_nombre; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col">
                <button type="submit" form="formularioTutor" id="btnGuardar" class="btn btn-primary w-100">Guardar</button>
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

<h1>Datatable de tutores</h1>
<div class="row justify-content-center">
    <div class="col table-responsive">
        <table id="tablaTutor" class="table table-bordered table-hover">
        </table>
    </div>
</div>
<script src="<?= asset('./build/js/tutores/index.js') ?>"></script>