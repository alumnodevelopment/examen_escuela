<h1 class="text-center">Registro de Pagos de los Alumnos</h1>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form class="border bg-light p-3" id="formularioPago">
                <div class="mb-3">                        
                    <input type="hidden" name="pago_id" id="pago_id" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="alumno_id" class="form-label">Seleccione un alumno:</label>
                    <select name="pago_alumno_id" id="pago_alumno_id" class="form-select">
                        <option value="">Seleccione un alumno</option>
                        <?php foreach ($alumnos as $alumno) { ?>
                            <option value="<?= $alumno['alumno_id'] ?>"><?= $alumno['alumno_nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="pago_fecha" class="form-label">Fecha de registro del pago:</label>
                    <input type="date" name="pago_fecha" id="pago_fecha" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="pago_monto" class="form-label">Monto del pago:</label>
                    <input type="number" step="0.01" name="pago_monto" id="pago_monto" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="pago_mes">Mes del pago:</label>
                    <select name="pago_mes" id="pago_mes" class="form-control">
                        <option value="">Seleccione el mes</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                    </select>
                </div>
                <div class="mb-3">
                        <label for="pago_solvencia">Se encuentra solvente:</label>
                        <select name="pago_solvencia" id="pago_solvencia" class="form-control">
                            <option value="">Seleccione</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                        </select>
                    </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" form="formularioPago" id="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
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
        <h1>Historial de Pagos de los Alumnos</h1>
        <div class="row justify-content-center">
            <div class="col table-responsive">
                <table id="tablaPagos" class="table table-bordered table-hover">
                    <!-- Contenido de la tabla aquí -->
                </table>
            </div>
        </div>
    </div>
</div>
<script src="<?= asset('./build/js/pagos/index.js') ?>"></script>