<?php
namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Pago;
use Exception;

class ReportePagoController
{
    
    public static function getPago($id_pago){
        $sql="select * from pagos
        inner join alumnos on pago_alumno_id = alumno_id
        where pago_id = ${id_pago} ";

        $pagosArray= Pago::fetchArray($sql);

        return $pagosArray;

    }

    public static function pdf(Router $router)
    {
        $id_pago = $_GET['id_pago'];

        $pagos = static::getPago($id_pago);

        // Crear un objeto mPDF
        $mpdf = new Mpdf([
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(50, 40, 25);

        $html = $router->load('reporte/pdf', [
            'pagos' => $pagos
        ]);


        $htmlHeader = $router->load('reporte/header');
        $htmlFooter = $router->load('reporte/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }



}