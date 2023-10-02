<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>DemoApp</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
        
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/ejemplo/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px'" alt="cit" >
                Aplicaciones
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/examen_escuela/"><i class="bi bi-house-fill me-2"></i>Inicio</a>
                    </li>
  
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/alumnos" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>ALUMNOS
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/alumnos"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE ALUMNOS</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/asistencia"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>ASISTENCIA DE ALUMNOS</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/conductas"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRAR CONDUCTA ALUMNO</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/pdfconductas"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>GENERAR REPORTE CONDUCTA</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/profesores" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>PROFESORES
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/profesores"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE PROFESORES</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/asistencia"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>ASISTENCIA DE ALUMNOS</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/pdfconductas"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>GENERAR REPORTE CONDUCTA</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/actividades"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>INGRESAR ACTIVIDADES</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/pdfasistencias"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>GENERAR REPORTE ASISTENCIA</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/grados" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>GRADOS Y SECCIONES
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/secciones"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE SECCIONES</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/grados"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE GRADOS</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/asignaciones"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>ASIGNAR GRADOS, SECCIONES, MAESTROS Y ALUMNOS</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/tutores" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>TUTORES
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/tutores"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE PADRES O TUTORES</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/pagos"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE PAGOS Y SOLVENCIA</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/pagos" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>PAGOS Y SOLVENCIA
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/pagos"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO DE PAGOS Y SOLVENCIA</a>
                            </li>
                        </ul>
                    </div>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="/examen_escuela/usuarios" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>LOGIN Y REGISTRO
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/login"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>LOGIN</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/examen_escuela/registro"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>REGISTRO</a>
                            </li>
                        </ul>
                    </div> 

                </ul> 
                <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                    <!-- Ruta relativa desde el archivo donde se incluye menu.php -->
                    <!-- <button class="btn btn-danger" type="submit" id="logout"
                            name="logout"><i class="bi bi-arrow-bar-left"></i>CERRAR SESIÓN</button> -->
                    <a href="/examen_escuela/" class="btn btn-danger"><i class="bi bi-arrow-bar-left"></i>SALIR</a>
                </div>

            
            </div>
        </div>
        
    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid " >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>
</html>