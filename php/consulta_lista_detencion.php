<?php
    include 'conexion_db.php';

    if (isset($_POST['query']) > 0 && isset($_POST['query']) != '') {
        $query = $_POST['query'];

        // Consulta SQL para obtener los datos

        $sql = "SELECT det.*, ddt.*, d.detenido_id
        FROM  detenciones det
        LEFT JOIN detalle_detenciones AS ddt ON ddt.detencion_idfk = det.detencion_id and det.oculto = 0
        LEFT JOIN detenidos AS d ON det.detenido_idfk = d.detenido_id AND d.oculto = 0
        WHERE det.numero = '$query'
        ORDER BY det.detencion_id DESC";
        $resultado_detencion = $conexion->query($sql);

        $row = $resultado_detencion->fetch_assoc();
        if ($row > 0){
            echo '<tr>';
            echo '<td>1</td>';
            echo '<td>'.$row["numero"].'</td>';
            echo '<td>'.$row["fecha_ingreso"].'</td>';
            echo '<td>'.$row["estatus"].'</td>';

            echo '<td><a href="detalle_detencion.php?id='.$row['detencion_id'].'"" title="Ver detalle de la Detención" class="btn btn-floating waves-effect waves-light blue"><i class="material-icons">info</i></a>';
            if (isset($_SESSION['r_usuario'])) {
                $r_usuario = json_decode($_SESSION['r_usuario']); // validamos que el usuario sea Administrador para editar y eliminar
                if ($r_usuario == '1') {
            echo '    <a href="editar_detencion.php?id='.$row['detencion_id'].'" title="Editar datos de la Detención" class="btn btn-floating waves-effect waves-light green"><i class="material-icons">edit</i></a>';
            echo '    <a href="eliminar_detencion.php?id='.$row['detencion_id'].'" title="Eliminar Registros" class="btn btn-floating waves-effect waves-light red"><i class="material-icons">delete</i></a>';
                }
            } // si no es ADMINISTRADOR no aparecerán las opciones

            echo '</td>';
            echo '</tr>';

        } else {
            echo '<tr><td colspan="5"><p class="center"><b>No se encontraron datos asociados a la búsqueda</b></p></td></tr>';
        }
        
    }
?>
