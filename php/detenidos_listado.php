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

    $sql= "SELECT d.*, dd.*, dir.*, det.detencion_id
    FROM detenidos AS d  
    LEFT JOIN detalle_detenidos AS dd ON dd.detenido_idfk = d.detenido_id  
    LEFT JOIN direcciones AS dir ON dd.direccion_idfk = dir.direccion_id
    LEFT JOIN detenciones AS det ON det.detenido_idfk = d.detenido_id AND det.oculto = 0
    WHERE d.oculto = 0
    AND det.estatus = 'DETENIDO'
    GROUP BY d.detenido_id
    ORDER BY d.detenido_id DESC
    LIMIT $start_from, $record_per_page";
    $resultado = $conexion->query($sql); 
            
        if(mysqli_num_rows($resultado) > 0){
            $cont = 1;

            $output .= "  
            <table class='table striped highlight centered responsive-table' id='tabla_detenidos'>
            <thead>  
                <tr style='font-size: 14px;'>  
                        <th>Nro.</th>  
                        <th>Cédula</th> 
                        <th>Nombre Completo</th> 
                        <th>Fecha de Nacimiento</th>
                        <th class='center'>Acciones</th>  
                </tr>
            </thead>";
            $output .= "<tbody style='font-size: 12px;' id='tabla_busqueda_detenidos'>"; 

            foreach ($resultado as $key):

                $output .= "<tr class='center'>
                                <td>".($cont++)."</td>
                                <td>".$nac = ($key['ciudadano_idfk']== '1') ? 'V-'.$key['cedula'] : 'E-'.$key['cedula']."</td>";
                $output .=" 
                                <td>".$key['primer_nombre']." ".$key['primer_apellido']."</td>
                                <td>".$key['fecha_nacimiento']."</td>
                                <td>";

                                if (!empty($key['detencion_id'])) { // SE CREA pg QUE ES UNA CLAVE DE PAGINA PARA MOSTRAR/OCULTAR ELEMENTOS EN HTML
                                    $output .=  "<a href='detalle_detenido.php?id=".$key['detenido_id']."' title='Ver Detalle del Detenido' class='btn btn-floating waves-effect waves-light blue'><i class='material-icons'>info</i></a>
                                                <a href='detenciones.php?id=".$key['detenido_id']."&pg=detenido' title='Ver las Detenciones Asociadas' class='btn btn-floating waves-effect waves-light black'><i class='material-icons'>manage_search</i></a>";
                                } else {
                                    $output .="<a href='detalle_detenido.php?id=".$key['detenido_id']."' title='Ver Detalle del Detenido' class='btn btn-floating waves-effect waves-light blue'><i class='material-icons'>info</i></a>";
                                }

                                    $output .="<a href='../pdf/reporte_datos.php?id=".$key['detenido_id']."' title='Descargar Ficha' class='btn btn-floating waves-effect waves-light'><i class='material-icons'>download</i></a>";
                                

                                    //         <a href='egresos.php?id=".$key['detenido_id']."' title='Ver los Egresos Asociados' class='btn btn-floating waves-effect waves-light black'><i class='material-icons'>manage_search</i></a>
                                    //         <a href='../pdf/reporte_egreso.php?id=".$key['detenido_id']."' title='Descargar Ficha de Egreso' class='btn btn-floating waves-effect waves-light'><i class='material-icons'>download</i></a>

                                    if (isset($_SESSION['r_usuario'])) {
                                        $r_usuario = json_decode($_SESSION['r_usuario']); // validamos que el usuario sea Administrador para editar y eliminar
                                        if ($r_usuario === '1') {
                                            $output .=" <a href='editar_detenido.php?id=".$key['detenido_id']."' title='Editar Datos del Detenido' class='btn btn-floating waves-effect waves-light green'><i class='material-icons'>edit</i></a>
                                                        <a href='eliminar_detenido.php?id=".$key['detenido_id']."' title='Eliminar Registros del Detenido' class='btn btn-floating waves-effect waves-light red'><i class='material-icons'>delete</i></a>";
                                        }
                                    } // si no es ADMINISTRADOR no aparecerán las opciones

                $output .= "</td></tr>";
            endforeach;

                $output .="</tbody></table><hr><br/>";  
        } else {
            $output .= "<p class='center'><b>No se encontraron detenidos</b></p>";
        }

    $page_query = "SELECT * FROM detenidos WHERE detenidos.oculto = 0";  
    $page_result = $conexion->query($page_query);

    $total_records = mysqli_num_rows($page_result);  
    $total_pages = ceil($total_records/$record_per_page);

    $output .= '<ul class="pagination center-align" id="paginador_detenidos_listado">';

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
   
   