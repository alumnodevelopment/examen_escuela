<?php
namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Conducta;
use Exception;

class ReporteConductaController{ 
public static function index(Router $router) {

    $alumnos = static::BuscarAlumnos();
    
    // $conductas = Conducta::all();

    $router->render('pdfconductas/index', [

        'alumnos' => $alumnos,
    ]);
}


    public static function pdf(Router $router){
        $alumno_id = $_GET['alumno_id'];
        $venta_fecha_fin = $_GET['venta_fecha_fin'];

        // Obtener los datos de ventas utilizando la funcion buscar
        $ventas = ConductaController::buscarAPI($alumno_id);

        // Crear un objeto mPDF
        $mpdf = new Mpdf([
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        // Cargar una vista HTML con los datos de ventas
        $html = $router->load('ReporteConducta/pdf', [
            'ventas' => $ventas
          
 // Pasa los datos de ventas a la vista
        ]);
        // var_dump($ventas);
        // exit();


        // Configurar encabezado y pie de página
        $htmlHeader = $router->load('ReporteConducta/header');
        $htmlFooter = $router->load('ReporteConducta/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        // Agregar el contenido HTML al PDF
        $mpdf->WriteHTML($html);

        // Generar el PDF y mostrarlo o descargarlo
        $mpdf->Output();
    }



    ///otra prueba



    public static function generarPDF(Router $router)
{
    $datos = json_decode(file_get_contents('php://input'));

    // Cargar una vista HTML con los datos
    $html = $router->load('ReporteConducta/pdf', [
        'ventas' => $datos // Pasa los datos directamente a la vista
    ]);




    // Crear un objeto mPDF
    $mpdf = new Mpdf();



    // Configurar encabezado y pie de página si es necesario
    $htmlHeader = $router->load('ReporteConducta/header');
    $htmlFooter = $router->load('ReporteConducta/footer');
    $mpdf->SetHTMLHeader($htmlHeader);
    $mpdf->SetHTMLFooter($htmlFooter);

    // Agregar el contenido HTML al PDF
    $mpdf->WriteHTML($html);

    // Generar el PDF y mostrarlo o descargarlo
    $mpdf->Output();
}
public static function buscarAPI() {

    $alumno_id = $_GET['alumno_id'] ?? '';
    $conducta_fecha = $_GET['conducta_fecha'] ?? '';


    $sql = "SELECT c.conducta_id, a.alumno_nombre, c.conducta_fecha, c.conducta_descripcion
    FROM conducta c
    INNER JOIN alumnos a ON a.alumno_id = c.alumno_id
    WHERE c.conducta_situacion = 1;";

    if ($alumno_id != '') {
        $sql .= " AND a.alumno_id LIKE '%${alumno_id}%'";
    }

    if ($conducta_fecha != '') {
        $sql .= " AND c.conducta_fecha LIKE '%${conducta_fecha}%'";
    }
   

    try {
        $conductas = Conducta::fetchArray($sql);
        echo json_encode($conductas);
    } catch (Exception $e) {
        echo json_encode([
            'detalle' => $e->getMessage(),
            'mensaje' => 'Ocurrió un error',
            'codigo' => 0,
        ]);
    }
}


public static function BuscarAlumnos(){

    $sql = "SELECT * FROM alumnos WHERE alumno_situacion = 1";

    try {
        $alumnos = Conducta::fetchArray($sql);
        return $alumnos;
    } catch (Exception $e) {

    }
    
}

 }