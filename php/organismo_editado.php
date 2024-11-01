<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!isset($_REQUEST['codigo_organismo'])) {
        $codigo = $_REQUEST['codigo_organismo_hidden'];
    } else{
         $codigo = $_REQUEST['codigo_organismo'];
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



    $direccion_id = $_POST['direccion_id'];
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);

    $sql = "UPDATE direcciones SET  estado ='$estado',
                                    municipio='$municipio',
                                    direccion='$direccion'

                                WHERE direccion_id = $direccion_id";
    $res = $conexion->query($sql);

    if ($res) {
        $org_sql = "UPDATE organismos SET codigo ='$codigo',
                                  nombre='$nombre',
                                  descripcion='$descripcion',
                                  telefono='$telefono',
                                  correo='$correo'

                                WHERE organismo_id = $id";
        $result = $conexion->query($org_sql);

        if ( $result) {
            header('Location: editar_organismo.php?id='. $id);
        }
        else {
            echo "error:editar_organismo";
        }
    } 
    else {
        echo "error:editar_direccion_organismo";
    }
} 
else {
    echo "error:editar_general";
}
?>