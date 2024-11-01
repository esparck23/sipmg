<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

$cedula = $_REQUEST["cedula"];

$sql = "SELECT
                detenido_id
             FROM
                 detenidos
            WHERE
                cedula = '$cedula'";
             $result = mysqli_query($conexion,$sql);

             $row = mysqli_num_rows($result);

             if ($row > 0) {
                echo "exito";
             } else {
                echo "error";
             }
?>