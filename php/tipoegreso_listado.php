<?php
    include 'conexion_db.php'; 
    $record_per_page = 3;
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

    // Consulta SQL para obtener los datos
    $sql = "SELECT *
    FROM  tipo_egresos
    ORDER BY tipo_egresos.tipoegreso_id DESC LIMIT $start_from, $record_per_page";
    $resultado = $conexion->query($sql);

    $output .= "  
        <table class='table striped highlight centered responsive-table' id='tabla_delitos'>
        <thead>  
            <tr style='font-size: 14px;'>  
                    <th>Nro.</th>  
                    <th>Tipo de Egreso</th> 
                    <th class='center'>Acciones</th>  
            </tr>
        </thead>";
      

    $output .= "<tbody style='font-size: 12px;' id='tabla'>";  
            
        if(mysqli_num_rows($resultado) > 0){
            $cont = 1;
            foreach ($resultado as $key):

                $output .= "<tr class='center'>
                                <td>".($cont++)."</td>";
                $output .=" 
                                <td>".$key['nombre']."</td>
                                <td>";
                if (isset($_SESSION['r_usuario'])) {
                    $r_usuario = json_decode($_SESSION['r_usuario']); // validamos que el usuario sea Administrador para editar y eliminar
                    if ($r_usuario === '1') {
                
                $output .="
                                    <a href='editar_tipoegreso.php?id=".$key['tipoegreso_id']."' title='Editar Tipo de Egreso' class='btn btn-floating waves-effect waves-light green'><i class='material-icons'>edit</i></a>
                                    <a href='eliminar_tipoegreso.php?id=".$key['tipoegreso_id']."' title='Eliminar Registros' class='btn btn-floating waves-effect waves-light red'><i class='material-icons'>delete</i></a>";
                    }
                } // si no es ADMINISTRADOR no aparecerán las opciones
                $output .="</td>";         
                $output .="</tr>";
            endforeach;
        }
    $output .="</tbody></table><hr><br/>";  
        
    $page_query = "SELECT * FROM tipo_egresos";  
    $page_result = $conexion->query($page_query);

    $total_records = mysqli_num_rows($page_result);  
    $total_pages = ceil($total_records/$record_per_page);

    $output .= '<ul class="pagination center-align">';

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
   
   