<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

$n_expediente = $_REQUEST["expediente"];

$sql = "SELECT
                detencion_id
             FROM
                detenciones
            WHERE
                numero = '$n_expediente'";
             $result = mysqli_query($conexion,$sql);

             $row = mysqli_num_rows($result);

             if ($row > 0) {
                echo 1;
             } else {
                echo 2;
             }
?>