<?php
include 'conexion_db.php';

    if (isset($_POST['query']) > 0 && isset($_POST['query']) != '') {
        $query = $_POST['query'];

        // Consulta SQL para obtener los datos

        $sql = "SELECT d.*, dd.*, dir.*, dt.detencion_id
        FROM  detenidos  AS  d  
        LEFT JOIN  detalle_detenidos  AS  dd  ON  dd . detenido_idfk  =  d . detenido_id 
        LEFT JOIN detenciones AS dt ON dt.detenido_idfk = d.detenido_id AND dt.oculto = 0  
        LEFT JOIN  direcciones  AS  dir  ON  dd . direccion_idfk  =  dir . direccion_id
        WHERE d.oculto = 0  
        AND d.cedula = '$query'
        OR dt.numero = '$query'
        GROUP BY d.detenido_id
        ORDER BY d.detenido_id DESC";
        $resultado = $conexion->query($sql);
        
        $row = $resultado->fetch_assoc();
        if ($row > 0){
            echo '<tr>';
            echo '<td>1</td>';
            echo '<td>'.$nac = ($row["ciudadano_idfk"]== "1") ? "V-".$row["cedula"] : "E-".$row["cedula"].'</td>';
            echo '<td>'.$row["primer_nombre"]." ".$row["primer_apellido"].'</td>';
            echo '<td>'.$row["fecha_nacimiento"].'</td>';
            echo '<td><a href="detalle_detenido.php?id='.$row['detenido_id'].'"" title="Ver detalle del Detenido" class="btn btn-floating waves-effect waves-light blue"><i class="material-icons">info</i></a>';
            if (!empty($row['detencion_id'])) {
                echo '      <a href="detenciones.php?id='.$row['detenido_id'].'" title="Ver Detenciones asociadas" class="btn btn-floating waves-effect waves-light black"><i class="material-icons">manage_search</i></a>';
            }
            echo '      <a href="descarga_ficha.php?id='.$row['detenido_id'].'" title="Descargar Ficha del Detenido" class="btn btn-floating waves-effect waves-light"><i class="material-icons">download</i></a>';
            if (isset($_SESSION['r_usuario'])) {
                $r_usuario = json_decode($_SESSION['r_usuario']);
                if ($r_usuario === '1') {
            echo '      <a href="editar_detenido.php?id='.$row['detenido_id'].'" title="Editar datos del Detenido" class="btn btn-floating waves-effect waves-light green"><i class="material-icons">edit</i></a>';
            echo '      <a href="eliminar_detenido.php?id='.$row['detenido_id'].'" title="Eliminar registros del Detenido" class="btn btn-floating waves-effect waves-light red"><i class="material-icons">delete</i></a>';
                }
            } // si no es ADMINISTRADOR no aparecerán las opciones
            echo '</td>';
            echo '</tr>';
        } else {
            echo '<tr><td colspan="5"><p class="center"><b>No se encontraron datos asociados a la búsqueda</b></p></td></tr>';
        }
    }
?>