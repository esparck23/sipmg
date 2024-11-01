<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!isset($_REQUEST['codigo_delito'])) {
        $codigo = $_REQUEST['codigo_delito_hidden'];
    } else{
         $codigo = $_REQUEST['codigo_delito'];
    }

    
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);


    $sql = "UPDATE delitos SET codigo='$codigo', nombre='$nombre', descripcion='$descripcion' WHERE delito_id = $id";
    $res = $conexion->query($sql);

    if ($res) {
       
        header('Location: editar_delito.php?id='. $id);
    } else {
        echo "error:editar_delito";
    }
}
else {
    echo "error:editar_general";
}
?>