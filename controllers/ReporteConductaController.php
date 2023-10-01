<?php
namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Conducta;
use Exception;

class ReporteConductaController
{
    public static function index(Router $router)
    {
        $alumnos = self::BuscarAlumnos();
        $router->render('pdfconductas/index', [
            'alumnos' => $alumnos,
        ]);
    }

    public static function pdf(Router $router)
    {
        $alumno_id = $_GET['alumno_id'] ?? '';
        $conducta_fecha = $_GET['conducta_fecha'] ?? '';

        $conductas = self::buscarAPI($alumno_id, $conducta_fecha);

        $mpdf = new Mpdf([
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        $html = $router->load('ReporteConducta/pdf', [
            'conductas' => $conductas
        ]);

        $htmlHeader = $router->load('ReporteConducta/header');
        $htmlFooter = $router->load('ReporteConducta/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public static function generarPDF(Router $router)
    {
        $datos = json_decode(file_get_contents('php://input'));

        $html = $router->load('ReporteConducta/pdf', [
            'conductas' => $datos // Pasa los datos directamente a la vista
        ]);

        $mpdf = new Mpdf();

        $htmlHeader = $router->load('ReporteConducta/header');
        $htmlFooter = $router->load('ReporteConducta/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
    public static function buscarAPI()
    {
        $alumno_id = $_GET['alumno_id'] ?? '';
        $conducta_fecha = $_GET['conducta_fecha'] ?? '';
    
        //$alumno_id = Conducta::($alumno_id); // Sanitiza el input para prevenir SQL injection
        //$conducta_fecha = Conducta::($conducta_fecha); // Sanitiza el input para prevenir SQL injection
    
        $sql = "SELECT c.conducta_id, a.alumno_nombre, c.conducta_fecha, c.conducta_descripcion
                FROM conducta c
                INNER JOIN alumnos a ON a.alumno_id = c.alumno_id
                WHERE c.conducta_situacion = 1";
    
        // Agregar condiciones según los parámetros de búsqueda
        if (!empty($alumno_id)) {
            $sql .= " AND a.alumno_id = '{$alumno_id}'";
        }
    
        if (!empty($conducta_fecha)) {
            $sql .= " AND c.conducta_fecha = '{$conducta_fecha}'";
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
    
    public static function BuscarAlumnos()
    {
        $sql = "SELECT * FROM alumnos WHERE alumno_situacion = 1";

        try {
            return Conducta::fetchArray($sql);
        } catch (Exception $e) {
            // Manejar el error
            return [];
        }
    }
}
