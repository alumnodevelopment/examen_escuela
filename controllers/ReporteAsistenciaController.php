<?php
namespace Controllers;

use Mpdf\Mpdf;
use MVC\Router;
use Model\Asistencia;
use Model\Grado;
use Model\Seccion;
use Model\Asignaciones;
use Exception;

class ReporteAsistenciaController
{
    public static function index(Router $router)
    {
        $grados = self::BuscarGrado();
        $secciones = self::BuscarSeccion();

        $router->render('pdfasistencias/index', [
            'grados' => $grados,
            'secciones' => $secciones,
        ]);
    }

    public static function pdf(Router $router)
    {
        $grado_id = $_GET['grado_id'] ?? '';
        $seccion_id = $_GET['seccion_id'] ?? '';
        $asistencia_fecha = $_GET['asistencia_fecha'] ?? '';

        $asistencias = self::buscarAPI($grado_id, $seccion_id, $asistencia_fecha);

        $mpdf = new Mpdf([
            "orientation" => "P",
            "default_font_size" => 12,
            "default_font" => "arial",
            "format" => "Letter",
            "mode" => 'utf-8'
        ]);
        $mpdf->SetMargins(30, 35, 25);

        $html = $router->load('reporteAsistencia/pdf', [
            'asistencias' => $asistencias
        ]);

        $htmlHeader = $router->load('reporteAsistencia/header');
        $htmlFooter = $router->load('reporteAsistencia/footer');
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter($htmlFooter);

        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    
    public static function buscarAPI()
    {
        $grado_id = $_GET['grado_id'] ?? '';
        $seccion_id = $_GET['seccion_id'] ?? '';
        $asistencia_fecha = $_GET['asistencia_fecha'] ?? '';
    
    
        $sql = "SELECT
                    g.grado_nombre ,
                    s.seccion_nombre ,
                    COUNT (distinct x.asistencia_id) conteo,
                    SUM(CASE WHEN x.asistencia_situacion = 1 THEN 1 ELSE 0 END)  presentes,
                    SUM(CASE WHEN x.asistencia_situacion = 0 THEN 1 ELSE 0 END)  ausentes,
                    x.asistencia_fecha
                FROM
                    grados g
                INNER JOIN
                    asignaciones a ON g.grado_id = a.asignacion_grado and a.asignacion_situacion = 1
                INNER JOIN
                    secciones s ON a.asignacion_seccion = s.seccion_id
                LEFT JOIN
                    asistencia x ON a.asignacion_alumno = x.alumno_id and (x.asistencia_situacion = 1 OR x.asistencia_situacion = 0  )
                WHERE
                    (x.asistencia_situacion = 1 OR x.asistencia_situacion = 0  )
                AND
                    g.grado_id = $grado_id
                AND 
                    s.seccion_id = $seccion_id   
                GROUP BY
                    g.grado_nombre, s.seccion_nombre,x.asistencia_fecha
                ORDER BY
                    g.grado_nombre, s.seccion_nombre; ";
        
            $asistencias = Asistencia::fetchArray($sql);
            return $asistencias;
        
    }
    
    public static function buscarGrado(){
        $sql = "SELECT * FROM grados where grado_situacion = 1";
    
        try{
            $grados = Grado::fetchArray($sql);
            return $grados; 
        } catch (Exception $e){
            return []; 
        }
    }
    
    public static function buscarSeccion(){
        $sql = "SELECT * FROM secciones where seccion_situacion = 1";
    
        try{
            $secciones = Seccion::fetchArray($sql);
            return $secciones; 
        } catch (Exception $e){
            return []; 
        }
    }
}
