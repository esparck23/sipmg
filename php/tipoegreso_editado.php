<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);

    $sql = "UPDATE tipo_egresos SET nombre='$nombre' WHERE tipoegreso_id = $id";
    $res = $conexion->query($sql);

    if ($res) {
       
        header('Location: editar_tipoegreso.php?id='. $id);
    } else {
        echo "error:editar_tipoegreso";
    }
}
else {
    echo "error:editar_general";
}
?>