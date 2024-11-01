<?php
    ob_start();
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = trim($_POST['codigo_delito']);
        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion']);

        $sql = "INSERT INTO delitos (codigo, nombre, descripcion) VALUES ('$codigo', '$nombre','$descripcion')";
        $result = $conexion->query($sql);

        if ($result) {
           header("Location: delitos.php");
        } else{
            echo "error:registro_delito";
        }
    }

    ob_end_flush();
?>