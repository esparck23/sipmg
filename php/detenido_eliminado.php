<?php
include 'conexion_db.php';

if (isset($_REQUEST['detenido_id'])) {
    $id = $_REQUEST['detenido_id'];

    ################################################// OCULTO SIGNIFICA QUE NO APARECERÁ EN SISTEMA.
    $sql = "UPDATE
            detenidos
            SET
                oculto = 1
            WHERE detenido_id = '$id'";
    $result = $conexion->query($sql);

    // OCULTAR TAMBIEN SUS DETENCIONES
    $sql_detencion = "UPDATE
    detenciones
    SET
        oculto = 1
    WHERE detenido_idfk = '$id'";
    $result_detencion = $conexion->query($sql_detencion);

    if ($result && $result_detencion)  {
        echo "exito";
    }
    else {
        echo "error:eliminar_detenido";
    }
}
?>