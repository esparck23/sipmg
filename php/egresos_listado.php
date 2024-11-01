<?php
    include 'conexion_db.php'; 
    $record_per_page = 5;
    $page = '';
    $output = '';
    session_start();
    if(isset($_POST["page"]))  
    {  
        $page = $_POST["page"];  
    }  
    else  
    {  
        $page = 1;  
    }
    $start_from = ($page - 1)* $record_per_page;
    
    // IMPRESION DE TABLA CON PAGINADOR INCLUIDO

    $sql_egreso = "SELECT ed.*, det.detencion_id, det.numero, d.detenido_id, d.cedula, d.ciudadano_idfk, dd.*
    FROM egreso_detenciones ed
    LEFT JOIN tipo_egresos AS te ON ed.tipoegreso_idfk = te.tipoegreso_id
    LEFT JOIN detenciones det ON det.detencion_id = ed.detencion_idfk
    LEFT JOIN detenidos d ON det.detenido_idfk = d.detenido_id
    LEFT JOIN detalle_detenidos dd ON dd.detenido_idfk = d.detenido_id
    WHERE NOT EXISTS (
        SELECT 1
        FROM detenciones det_sub
        WHERE det_sub.detencion_id = ed.detencion_idfk
        AND det_sub.oculto = 1
    )
    GROUP BY ed.egreso_id
    ORDER BY ed.egreso_id DESC
    LIMIT $start_from, $record_per_page";
    $resultado = $conexion->query($sql_egreso);  
            
    if(mysqli_num_rows($resultado) > 0){
        $cont = 1;

        $output .= "  
        <table class='table striped highlight centered responsive-table' id='tabla_egresos'>
        <thead>  
            <tr style='font-size: 14px;'>  
                    <th style='width: 5%'>Nro.</th>  
                    <th style='width: 20%'>Cédula</th> 
                    <th style='width: 25%'>Nombre Completo</th>
                    <th style='width: 10%'>Expediente</th>
                    <th class='center' style='width: 40%'>Acciones</th>  
            </tr>
        </thead>";
      

        $output .= "<tbody style='font-size: 12px;' id='tabla_busqueda_egresado'>";
        
        foreach ($resultado as $key):
    
            $output .= "<tr class='center'>
                            <td>".($cont++)."</td>
                            <td>".$nac = ($key['ciudadano_idfk']== '1') ? 'V-'.$key['cedula'] : 'E-'.$key['cedula']."</td>";
                            $output .=" 
                            <td>".$key['primer_nombre']." ".$key['primer_apellido']."</td>
                            <td>".$key['numero']."</td>
                            <td>";
                            $output .=  "<a href='detalle_egresado.php?id=".$key['detenido_id']."' title='Ver Detalle del Egresado' class='btn btn-floating waves-effect waves-light blue'><i class='material-icons'>info</i></a>";
                            
                            if (isset($_SESSION['r_usuario'])) {
                                $r_usuario = json_decode($_SESSION['r_usuario']); // validamos que el usuario sea Administrador para editar y eliminar
                                if ($r_usuario === '1') {
                                        $output .=  "<a href='editar_detenido.php?id=".$key['detenido_id']."&pg=egreso' title='Editar Datos del Egresado' class='btn btn-floating waves-effect waves-light pink'><i class='material-icons'>edit_note</i></a>";
                                    }
                                } // si no es ADMINISTRADOR no aparecerán las opciones
                            $output .=  "<a href='detenciones.php?id=".$key['detenido_id']."&pg=egreso' title='Ver las Detenciones Asociadas' class='btn btn-floating waves-effect waves-light black'><i class='material-icons'>manage_search</i></a>
                                         <a href='../pdf/reporte_egreso.php?id=".$key['detenido_id']."' title='Descargar Ficha de Egreso' class='btn btn-floating waves-effect waves-light'><i class='material-icons'>download</i></a>";
                if (isset($_SESSION['r_usuario'])) {
                    $r_usuario = json_decode($_SESSION['r_usuario']); // validamos que el usuario sea Administrador para editar y eliminar
                    if ($r_usuario === '1') {
                
                        $output .="
                            <a href='editar_egreso.php?id=".$key['detencion_id']."' title='Editar Datos del Egreso' class='btn btn-floating waves-effect waves-light green'><i class='material-icons'>edit</i></a>
                            <a href='eliminar_egreso.php?id=".$key['detencion_id']."' title='Eliminar Registros' class='btn btn-floating waves-effect waves-light red'><i class='material-icons'>delete</i></a>";
            

                    }
                } // si no es ADMINISTRADOR no aparecerán las opciones
                $output .="</td>";         
                $output .="</tr>";
        endforeach;
                $output .="</tbody></table><hr><br/>";

    } else {
        $output .= "<p class='center'><b>No se encontraron egresados</b></p>";
    }
         
        
    $page_query = "SELECT * FROM detenciones, egreso_detenciones WHERE detenciones.detencion_id = egreso_detenciones.detencion_idfk AND detenciones.oculto = 0";  
    $page_result = $conexion->query($page_query);

    $total_records = mysqli_num_rows($page_result);  
    $total_pages = ceil($total_records/$record_per_page);

    $output .= '<ul class="pagination center-align" id="paginador_detenidos_egresados_listado">';

    // Calcula si se deben mostrar las flechas de izquierda y derecha
    $mostrar_flecha_izquierda = $page > 1;
    $mostrar_flecha_derecha = $page < $total_pages;

    if ($mostrar_flecha_izquierda){
        $output .= "<li class='waves-effect'><a class='izquierda' id='$page'><i class='material-icons'>chevron_left</i></a></li>";
    }
    for($i=1; $i<=$total_pages; $i++){
        $active = ($i == $page) ? "active" : "";
        $output .= "<li class='pagination_link waves-effect $active'><a id='$i'>$i</a></li>";  
    }
    if ($mostrar_flecha_derecha){
        $output .= "<li class='waves-effect'><a class='derecha' id='$page'><i class='material-icons'>chevron_right</i></a></li>";
    }  
    $output .= '</ul></div><br /><br />';
    echo $output;  
 ?>
   
   