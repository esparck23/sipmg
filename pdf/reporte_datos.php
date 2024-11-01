<?php
require_once 'dompdf/autoload.inc.php'; // LIBRERIA DOMPDF
require_once '../php/conexion_db.php'; // CONEXION A LA BASE DE DATOS
// Set the time zone
date_default_timezone_set('America/Caracas');


use Dompdf\Dompdf;
use Dompdf\Options;


    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
    }


    // Crear el documento HTML
    $html = '<!DOCTYPE html>'; 
    $html = '<html lang="es">';
    $html .= '<head>';
    $html .= '<style>';
    $html .= 'table { width: 100%; border-collapse: collapse; border: 1px solid black; }';
    $html .= 'td { border: 1px solid black; }';
    $html .= '</style>';
    $html .= '</head>';
    $html .= '<body>';

    // ENCABEZADOS
    $html .= '<h3 style="text-align:left; margin-top: -30px;">REPORTE DE SISTEMA</h3>';
    $html .= '<div style="position:float;">
                <div style="margin-top: -30px;">
                    <h4>Sistema de Información de la Policía Municipal de Guaicaipuro (SIPMG)</br>
                        Los Teques, Edo. Bolivariano de Miranda, Venezuela.</br>
                        Fecha:&nbsp;';setlocale(LC_ALL, 'es_ES.UTF-8','esp'); $fecha= date("m/d/Y");$marca = strtotime($fecha); $html .= strftime('%d de %B de %Y', $marca).'.
                    </h4>
                </div>
                <div style="position:right;"><img src="http://127.0.0.1/sipmg/img/policiamg.png" style="width: 100px; height: 100px; margin-top: -100px;margin-left: 900px;">';
    $html .= '</div></div>';
    $html .= '<h3 style="text-align:center;margin-top:-5px;">DATOS DEL DETENIDO</h3>';

    // PALABRA DATOS PERSONALES
    $html .= '<table style="margin-top:20px; width: 100%;">';
    $html .= '<tr>';
    $html .= '<th colspan="4" style="text-align: center; font-weight: bold; background-color:#b5b5b5">DATOS PERSONALES</th>';
    $html .= '</tr>';


    // CONSULTA DE LOS DATOS DEL DETENIDO
    $sql = "SELECT * FROM detenidos d, detalle_detenidos dd, direcciones dir WHERE d.detenido_id ='$id' AND dd.detenido_idfk = d.detenido_id AND dd.direccion_idfk = dir.direccion_id";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();

    // TITULOS DE LOS DATOS PERSONALES
    $html .= '<tr>';
    $html .= '<td style="width: 15%;">
                <img src="http://127.0.0.1/sipmg/php/fotosdetenido/'.$row["nombre_foto"].'" style="width: 160px; height: 135px;">';
    $html .= '<td>';
    
    $html .= '<td style="width: 20%;">';
        $html .='<table style="width: 100%;">';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Nombres y Apellidos</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Identificación</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Fecha de Nacimiento</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Sexo</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Edad</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="font-weight: bold;">Dirección de Residencia</td>';
        $html .= '</tr>';
    $html .= '</td>';

    // DETALLE DE LOS DATOS PERSONALES
    $html .= '<td style="width: 65%;">';
        $html .='<table style="width: 100%;">';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'.$row["primer_nombre"].'&nbsp;'.$row["segundo_nombre"].'&nbsp;'.$row["primer_apellido"].'&nbsp;'.$row["segundo_apellido"].'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'.$nac = ($row["ciudadano_idfk"]== "1") ? "V-".$row["cedula"] : "E-".$row["cedula"].'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'.$row['fecha_nacimiento'].'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'. $retVal = ($row["sexo"] == 1) ? "MASCULINO" : "FEMENINO".'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'.$row["edad"].' AÑOS</td>';
        $html .= '</tr>';
        $html .= '<tr>';
            $html .= '<td style="width: 80%;">'.$row["direccion"].',&nbsp;'.$row["municipio"].',&nbsp;'.$row["estado"].'</td>';
        $html .= '</tr>';
    $html .= '</td>';
    $html .= '</tr>';
    $html .= '</table>';
    // FINAL TABLA DE LOS DATOS PERSONALES


    // ################### INICIO TABLA DE DETENCIONES
    $html .= '<table>';

    // Fila con el título
    $html .= '<tr>';
    $html .= '<td colspan="8" style="text-align: center; font-weight: bold; background-color:#b5b5b5">HISTORIAL DE DETENCIONES</td>';
    $html .= '</tr>';

    $html .= '<tr style="text-align: center; font-weight: bold;">';
    $columnas = array(
        "Nro",
        "Nro. Expediente",
        "Estatus",
        "Fecha de Ingreso",
        "Organismo",
        "Delito",
        "Descripcion del Delito",
        "Dirección de Aprehensión"
    );

    $anchoColumnas = array(3,10, 10, 10, 10, 10, 23, 24);
    for ($i = 0; $i < count($columnas); $i++) {
        $html .= '<td style="width: ' . $anchoColumnas[$i] . '%;">' . $columnas[$i] . '</td>';
    }
    $html .= '</tr>';


    // TRAER LAS DETENCIONES ASOCIADAS
    $sql = "SELECT detenciones.*, detalle_detenciones.*, direcciones.*, detenidos.detenido_id, organismos.nombre AS organismo, delitos.nombre AS delito, delitos.descripcion AS delito_desc
                FROM detenciones 
                LEFT JOIN detalle_detenciones ON detalle_detenciones.detencion_idfk = detenciones.detencion_id 
                LEFT JOIN detenidos ON detenciones.detenido_idfk = detenidos.detenido_id
                LEFT JOIN direcciones ON detalle_detenciones.direccion_idfk = direcciones.direccion_id
                LEFT JOIN organismos ON detenciones.organismo_idfk = organismos.organismo_id
                LEFT JOIN delitos ON detenciones.delito_idfk = delitos.delito_id
                WHERE detenidos.detenido_id = '$id'
                ORDER BY detenciones.detencion_id DESC";
    $resultado_detencion = $conexion->query($sql);

    if(mysqli_num_rows($resultado_detencion) > 0){
        $cont = 1;
        
        foreach ($resultado_detencion as $key):
            $html .= '<tr class="center">';
            $html .= '<td>'.($cont++).'</td>';
            $html .= '<td>'.$key['numero'].'</td>';
            $html .= '<td>'.$key['estatus'].'</td>';
            $html .= '<td>'.$key['fecha_ingreso'].'</td>';
            $html .= '<td>'.$key['organismo'].'</td>';
            $html .= '<td>'.$key['delito'].'</td>';
            $html .= '<td>'.$key['descripcion'].'</td>';
            $html .= '<td>'.$key["direccion"].',&nbsp;'.$key["municipio"].',&nbsp;'.$key["estado"].'.</td>';
            $html .= '</tr>';
        endforeach;
    }

$html .= '</table>';
$html .= '</body>';
$html .= '</html>';


// ################################################
// Configuración de DomPDF
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);

// Crear una instancia de DomPDF
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);


// (Opcional) Configuración del papel y orientación
$dompdf->setPaper('A4', 'landscape');

// Generar el PDF
$dompdf->render();


$canvas = $dompdf->getCanvas();
$canvas->page_text(812, 570, "{PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));



// // Descargar el PDF
$dompdf->stream('sipmg_detenciones_'.$nac, array('Attachment' => TRUE,'enable_remote' => TRUE));
?>