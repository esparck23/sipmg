<?php
include 'conexion_db.php';

if (isset($_REQUEST['detencion_id'])) {
    $id = $_REQUEST['detencion_id'];

        $sql_final = "UPDATE
        detenciones
        SET
            oculto = 1
        WHERE detencion_id = '$id'";
        $final = $conexion->query($sql_final);
        echo "exito";
     
    } else {
        echo "error:eliminar_egreso_detencion";
    }
?>