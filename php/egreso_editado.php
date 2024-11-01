<?php
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $detencion = 0;
        $antigua_detencion = 0;

        if (!isset($_REQUEST['tipo_egreso'])) {
            $tipo_egreso = $_REQUEST['tipoegreso_hidden'];
        } else{
            $tipo_egreso = $_REQUEST['tipo_egreso'];
        }
        if (!isset($_REQUEST['detencion'])) {
            $detencion = $_REQUEST['detencion_hidden'];

        } else if ($_REQUEST['detencion']) {

            // SI EL USUARIO SELECCIONA OTRA DETENCION DEL LISTADO, SE ASIGNA EL ID CORRESPONDIENTE AL EGRESO ACTUAL EN BASE DE DATOS
            $detencion = $_REQUEST['detencion'];

            // LUEGO, LA DETENCION ANTERIOR DEBE EDITARSE SU ESTATUS PARA DEVOLVERLA DE "EGRESADO" A "DETENIDO", Y PUEDA ESTAR DISPONIBLE EN EL LISTADO DE DETENCIONES
            $antigua_detencion = $_REQUEST['detencion_hidden'];

            // SE CAMBIA EL ESTATUS A "DETENIDO" A LA ANTIGUA DETENCION
            $sql = "UPDATE detenciones SET estatus = 'DETENIDO' WHERE detencion_id = '$antigua_detencion'";
            $res = $conexion->query($sql);

            if ($res) {
                
                // SE CAMBIA EL ESTATUS A "EGRESADO" A LA DETENCION ELEGIDA POR EL USUARIO
                $sql_det = "UPDATE detenciones SET estatus = 'EGRESADO' WHERE detencion_id = '$detencion'";
                $result = $conexion->query($sql_det);

    
            } else{
                header('Location: lista_egresos.php?msj=2');
            }
        }

        // SE LLENAN LAS DEMAS VARIABLES PARA IR CONTRA BASE DE DATOS
        $egreso_id = trim($_POST['egreso_id']);
        $fecha_egreso = trim($_POST['fecha_egreso']);
        $descripcion_egreso = trim($_POST['descripcion_egreso']);

        $sql = "UPDATE egreso_detenciones
                SET
                    fecha_egreso = '$fecha_egreso',
                    descripcion = '$descripcion_egreso',
                    tipoegreso_idfk = '$tipo_egreso',
                    detencion_idfk = '$detencion'
                WHERE egreso_id = '$egreso_id'";

                $resultado = $conexion->query($sql);

        if ($resultado) {
            header('Location: lista_egresos.php?msj=3');
        } else{
            header('Location: lista_egresos.php?msj=2');
        }
    }
?>