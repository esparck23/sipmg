<?php
    ob_start();
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);

        $sql = "INSERT INTO tipo_egresos (nombre) VALUES ('$nombre')";
        $result = $conexion->query($sql);

        if ($result) {
           header("Location: lista_egresos.php");
        } else{
            echo "error:registro_tipoegreso";
        }
    }

    ob_end_flush();
?>