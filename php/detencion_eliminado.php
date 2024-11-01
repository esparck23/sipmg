<?php
include 'conexion_db.php';

if (isset($_REQUEST['detencion_id'])) {
    $id = $_REQUEST['detencion_id'];

    // CAMBIAMOS EL ESTATUS DE LA DETENCION A OCULTO DEBIDO A QUE SE PROCEDIÓ A ELIMINAR EL EGRESO
    $sql = "UPDATE detenciones SET oculto = 1 WHERE detencion_id = '$id'";
    $res_det = $conexion->query($sql);
    if ($res_det) {

        // PROCEDEMOS A ELIMINAR EL EGRESO, DEBIDO A QUE NO TIENE OCULTO.
        $sql = "DELETE FROM egreso_detenciones WHERE detencion_idfk = '$id'";
        $res = $conexion->query($sql);
        if ($res_det) {
            echo 'exito';
        } else{
            echo 'error';
        }

    } else{
        echo 'error';
    }
}
?>