<?php
include 'conexion_db.php';

    if (isset($_POST['query']) > 0 && isset($_POST['query']) != '') {
        $query = $_POST['query'];
        $output = '';
    }

    // Consulta SQL para obtener los datos
    $sql_egreso = "SELECT d.*, dd.*, dir.*, det.detencion_id, det.numero, ed.*, te.nombre AS tipo_egreso
    FROM detenidos AS d  
    LEFT JOIN detalle_detenidos AS dd ON dd.detenido_idfk = d.detenido_id  
    LEFT JOIN direcciones AS dir ON dd.direccion_idfk = dir.direccion_id
    LEFT JOIN detenciones AS det ON det.detenido_idfk = d.detenido_id AND det.oculto = 0
    LEFT JOIN egreso_detenciones AS ed ON ed.detencion_idfk = det.detencion_id
    LEFT JOIN tipo_egresos AS te ON ed.tipoegreso_idfk = te.tipoegreso_id
    WHERE d.oculto = 0
    AND det.estatus = 'EGRESADO'
    OR det.numero = '$query'
    GROUP BY ed.egreso_id
    ORDER BY ed.egreso_id DESC";

    $resultado = $conexion->query($sql_egreso);
    $row = $resultado->fetch_assoc();

    if ($row > 0){
        echo '<tr>';
        echo '<td>1</td>';
        echo '<td>'.$nac = ($row["ciudadano_idfk"]== "1") ? "V-".$row["cedula"] : "E-".$row["cedula"].'</td>';
        echo '<td>'.$row["primer_nombre"]." ".$row["primer_apellido"].'</td>';
        echo '<td>'.$row["numero"].'</td>';
        echo '<td><a href="detalle_egresado.php?id='.$row['detenido_id'].'&detencion_id='.$row['detencion_id'].'"" title="Ver detalle del Egresado" class="btn btn-floating waves-effect waves-light blue"><i class="material-icons">info</i></a>';  
            if (isset($_SESSION['r_usuario'])) {
                $r_usuario = json_decode($_SESSION['r_usuario']);
                if ($r_usuario == '1') {
                    echo      '<a href="editar_detenido.php?id='.$row['detenido_id'].'&pg=egreso" title="Editar datos del Egresado" class="btn btn-floating waves-effect waves-light pink"><i class="material-icons">edit_note</i></a>';
                } // SI ES ADMINISTRADOR APARECERAN LAS OPCIONES
            }
            
        echo '    <a href="detenciones.php?id='.$row['detenido_id'].'&pg=egreso" title="Ver Detenciones asociadas" class="btn btn-floating waves-effect waves-light black"><i class="material-icons">manage_search</i></a>';
        echo '    <a href="../pdf/reporte_egreso.php?'.$row['detenido_id'].'" title="Descargar Ficha de Egreso" class="btn btn-floating waves-effect waves-light"><i class="material-icons">download</i></a>';
        
        if (isset($_SESSION['r_usuario'])) {
            $r_usuario = json_decode($_SESSION['r_usuario']);
            if ($r_usuario == '1') {
                echo '<a href="editar_egreso.php?id='.$row['detencion_id'].'" title="Editar datos del Egreso" class="btn btn-floating waves-effect waves-light green"><i class="material-icons">edit</i></a>';    
                echo '<a href="eliminar_egreso.php?id='.$row['detencion_id'].'" title="Eliminar registros" class="btn btn-floating waves-effect waves-light red"><i class="material-icons">delete</i></a>';
            } // SI ES ADMINISTRADOR APARECERAN LAS OPCIONES
        }

        echo '</td></tr>';
    } else {
        echo '<tr><td colspan="5"><p class="center"><b>No se encontraron datos asociados a la búsqueda</b></p></td></tr>';
    }
?>