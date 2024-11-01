<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

$codigo = $_REQUEST["codigo"];

   $sql = "SELECT
         codigo
   FROM
         organismos
   WHERE
         codigo = '$codigo'";
      $result = mysqli_query($conexion,$sql);
      $row = mysqli_num_rows($result);

      if ($row > 0) {
         echo "exito";
      } else {
         echo "error";
      }
?>