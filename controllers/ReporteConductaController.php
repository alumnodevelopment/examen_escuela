<?php
namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;

use Exception;

class ReporteConductaController {
    public static function pdf(Router $router){
        $venta_fecha_inicio = $_GET['venta_fecha_inicio'];
        $venta_fecha_fin = $_GET['venta_fecha_fin'];

        // Obtener los datos de ventas utilizando la funcion buscar
        $ventas = ConductaController::buscarAPI($venta_fecha_inicio, $venta_fecha_fin);

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

 }