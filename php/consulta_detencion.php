<?php
    include 'conexion_db.php'; 

    $record_per_page = 5;
    $page = '';
    $pg = '';
    $output = '';
    $detenido_id = $_GET["detenido_id"];
    
    if (isset($_GET['pg'])) {
        $pg = $_GET['pg'];
    }

    if(isset($_POST["page"])) 
    {  
        $page = $_POST["page"];
        
    }  
    else  
    {  
        $page = 1;  
    }
    $start_from = ($page - 1) * $record_per_page;
    // IMPRESION DE TABLA CON PAGINADOR INCLUIDO

    // Consulta SQL para obtener los datos de las detenciones
    $sql = "SELECT det.*, ddt.*, d.detenido_id
            FROM  detenciones det
            LEFT JOIN detalle_detenciones AS ddt ON ddt.detencion_idfk = det.detencion_id and det.oculto = 0
            LEFT JOIN detenidos AS d ON det.detenido_idfk = d.detenido_id AND d.oculto = 0
            WHERE d.detenido_id = '$detenido_id'
            ORDER BY det.detencion_id DESC
            LIMIT $start_from, $record_per_page";
    $resultado_detencion = $conexion->query($sql);

    if (mysqli_num_rows($resultado_detencion) > 0) {

    

        $output .= "  
            <table class='table striped highlight centered responsive-table' id='tabla_detenciones'>
            <thead>  
                <tr style='font-size: 14px;'>  
                        <th>Nro.</th>  
                        <th>Expediente</th> 
                        <th>Estatus</th> 
                        <th>Fecha Ingreso</th>
                        <th class='center'>Acciones</th>  
                </tr>
            </thead>";

        $output .= "<tbody style='font-size: 12px;' id='tabla'>";  
                
            if(mysqli_num_rows($resultado_detencion) > 0){
                $cont = 1;
                foreach ($resultado_detencion as $key):
                    $output .= "<tr class='center'>
                                    <td>".($cont++)."</td>
                                    <td>".$key['numero']."</td>
                                    <td>".$key['estatus']."</td>
                                    <td>".$key['fecha_ingreso']."</td>
                                    <td>
                                        <a href='detalle_detencion.php?id=".$key['detencion_id']."&dt=".$detenido_id."&pg=".$pg."' title='Ver Detalle de la Detención' class='btn btn-floating waves-effect waves-light blue referencia_detencion'><i class='material-icons'>info</i></a>
                                    </td>
                    </tr>";
                endforeach;
            }
            else{
                $output .= "<tr><td colspan='5' class='center'>No hay registros</td></tr>";
            }
        $output .="</tbody></table><hr><br/>";  
            
        $page_query = "SELECT * FROM detenciones WHERE detenciones.estatus = 'DETENIDO' AND detenciones.detenido_idfk = $detenido_id";
        $page_result = $conexion->query($page_query); 
        $total_records = mysqli_num_rows($page_result);  
        $total_pages = ceil($total_records/$record_per_page);

        $output .= '<ul class="pagination center-align">';

        // Calcula si se deben mostrar las flechas de izquierda y derecha
        $mostrar_flecha_izquierda = $page > 1;
        $mostrar_flecha_derecha = $page < $total_pages;

        if ($mostrar_flecha_izquierda){
            $output .= "<li class='waves-effect'><a class='izquierda_detencion' id='$page'><i class='material-icons'>chevron_left</i></a></li>";
        }
        for($i=1; $i<=$total_pages; $i++){
            $active = ($i == $page) ? "active" : "";
            $output .= "<li class='pagination_link_detencion waves-effect $active'><a id='$i'>$i</a></li>";  
        }
        if ($mostrar_flecha_derecha){
            $output .= "<li class='waves-effect'><a class='derecha_detencion' id='$page'><i class='material-icons'>chevron_right</i></a></li>";
        }  
        $output .= '</ul></div><br /><br/>';
        echo $output;
    }  
?>
