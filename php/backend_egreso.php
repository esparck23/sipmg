<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

if ($_REQUEST["tipo"] == "registro_egreso") {

        // INICIO VALORES GENERAL EGRESO ########

        $fecha_egreso = $_POST['fecha_egreso'];
        $descripcion_egreso = $_POST['descripcion_egreso'];
        $tipo_egreso = $_POST['tipo_egreso'];
        $detencion_id = $_POST['detencion_detenido'];

        // FIN VALORES GENERAL EGRESO ########
        
        // REGISTRAMOS EL EGRESO A CONTINUACION #####
        $query = "INSERT INTO egreso_detenciones
                        (fecha_egreso,
                        descripcion,
                        tipoegreso_idfk,
                        detencion_idfk)
                VALUES ('$fecha_egreso',
                        '$descripcion_egreso',
                        '$tipo_egreso',
                        '$detencion_id')"; // ID DE LA DETENCION

        $res = $conexion->query($query);

        if ($res) {

            $query = "UPDATE detenciones SET estatus = 'EGRESADO' WHERE detencion_id = '$detencion_id'";
            $resultado = $conexion->query($query);
            if ($resultado) {

                header("location:lista_egresos.php");

            } else {
                echo "error:editar_estatus";
            }
        }
        else {
            echo "error:insertar_egreso";
        }
}
else {
    echo "error:backend_egreso_general";
}




?>