<h1 class="text-center">Registro de usuarios</h1>
<div class="container">
    <div class="row justify-content-center mb-5">
        <form class="col-lg-8 border bg-light p-3" id="formularioUsuarios" accept-charset="UTF-8">
            <input type="hidden" name="usuario_id" id="usuario_id">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="usuario_nombre">Nombre de usuario</label>
                    <input type="text" name="usuario_nombre" id="usuario_nombre" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="usuario_password">Contraseña</label>
                    <input type="password" name="usuario_password" id="usuario_password" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="usuario_tipo">Tipo de usuario</label>
                    <select name="usuario_tipo" id="usuario_tipo" class="form-control">
                        <option value="">Seleccionar</option>
                        <option value="ALUMNO">Alumno</option>
                        <option value="TUTOR">Tutor</option>
                    </select>
                </div>
            </div>
            <div class="row ">
                <div class="col">
                    <button type="submit" form="formularioUsuarios" id="btnGuardar" class="btn btn-primary btn-block">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="<?= asset('./build/js/usuarios/index.js') ?>"></script>