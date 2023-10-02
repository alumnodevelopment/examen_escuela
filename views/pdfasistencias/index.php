<h1 class="text-center">Reporte </h1>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <form class="border bg-light p-3" id="formularioAsistencia">
                <div class="row mb-3">
                    <div class="col">
                        <label for="grado_id">GRADO</label>
                        <select name="grado_id" id="grado_id" class="form-control">
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
                        <label for="seccion_id">SECCION</label>
                        <select name="seccion_id" id="seccion_id" class="form-control">
                            <option value="">SELECCIONE...</option>
                            <?php foreach ($secciones as $seccion) : ?>
                                <option value="<?= $seccion['seccion_id'] ?>">
                                    <?= $seccion['seccion_nombre'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="asistencia_fecha" class="form-label">Fecha de asistenca:</label>
                    <input type="date" name="asistencia_fecha" id="asistencia_fecha" class="form-control">
                    <div class="row ">
                        <div class="col">
                            <button type="button" id="btnBuscar" class="btn btn-info btn-block">Buscar</button>
                        </div>
                    </div>
            </form>
        </div>
        <script src="<?= asset('./build/js/pdfasistencias/index.js') ?>"></script>