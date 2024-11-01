<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (!isset($_REQUEST['detenido'])) {
        $detenido = $_REQUEST['detenido_hidden'];
    } else{
        $detenido = $_REQUEST['detenido'];
    }
    
    if (!isset($_REQUEST['organismo'])) {
        $organismo = $_REQUEST['organismo_hidden'];
    } else{
        $organismo = $_REQUEST['organismo'];
    }
    if (!isset($_REQUEST['delito'])) {
        $delito = $_REQUEST['delito_hidden'];
    } else{
        $delito = trim($_REQUEST['delito']);
    }
    
    if (!isset($_REQUEST['estado'])) {
        $estado = $_REQUEST['estado_hidden'];
    } else{
        $estado = $_REQUEST['estado'];
    }
    
    if (!isset($_REQUEST['municipio'])) {
        $municipio = $_REQUEST['municipio_hidden'];
    } else{
        $municipio = $_REQUEST['municipio'];
    }

    $detencion_id = $_POST['id'];
    $f_ingreso = trim($_POST['f_ingreso']);
    $lugar_detencion = $_POST['lugar_detencion'];
    $descripcion_detencion = $_POST['descripcion_detencion'];
    $direccion_detencion= $_POST['direccion_detencion'];
    $direccion_id = trim($_POST['direccion_id']);
    

    // comenzamos a hacer los cambios en los campos de base de datos
    // bloque direcciones
    $sql = "UPDATE
        direcciones
    SET
        estado = '$estado',
        municipio = '$municipio',
        direccion = '$direccion_detencion'
    WHERE
        direccion_id = '$direccion_id'";
    $resultado = $conexion->query($sql);

    if ($resultado) {
        // bloque detenciones
        $query ="UPDATE
            detenciones
        SET
        organismo_idfk = '$organismo',
        delito_idfk = '$delito',
        detenido_idfk = '$detenido'
        WHERE
        detencion_id = '$detencion_id'"; 
        $result = $conexion->query($query);

        if ($result) {
            // bloque detalle_detenciones
            $sql ="UPDATE
            detalle_detenciones
            SET
            fecha_ingreso = '$f_ingreso',
            descripcion = '$descripcion_detencion',
            lugar = '$lugar_detencion',
            direccion_idfk = '$direccion_id'
            WHERE
            detencion_idfk = '$detencion_id'"; 
            $resultado = $conexion->query($sql);

            if ($resultado) {

                header('Location: editar_detencion.php?id='.$detencion_id);
                echo "exito";
            } else {
                echo "error:editar_detalle_detencion";
            }
        } else {
            echo "error:editar_detencion";
        }
    }  else {
        echo "error:editar_direccion";
    }

}  else {
    echo "error:sin_post";
}
?>