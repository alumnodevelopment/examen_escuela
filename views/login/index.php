<!DOCTYPE html>
<html>

<head>
    <title>INICIO DE SESION</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <h2 class="text-center mb-4 text-primary">Inicio de sesión</h2>
    <div class="row justify-content-center">
        <form class="col-lg-4 border rounded p-3">
            <div class="row mb-3">
                <div class="col">
                    <label for="usuario_nombre" class="form-label">Nombre de usuario</label>
                    <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="usuario_password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="usuario_password" name="usuario_password">
                </div>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Iniciar sesión</button>
            </div>
        </form>
        <div class="mt-3">
            <p class="mb-0 text-center">¿No tiene una cuenta?<a href="/examen_escuela/registro"
                    class="text-primary fw-bold ms-2">Registrarse</a></p>
        </div>
    </div>
    <script src="<?= asset('./build/js/login/index.js') ?>"></script>
</body>

</html>