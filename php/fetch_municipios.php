<?php

include 'conexion_db.php'; 

if (isset($_REQUEST['estado_id'])) {
    $estado_id = $_REQUEST["estado_id"];
    $query = "SELECT * FROM municipios WHERE id_estado = '$estado_id'";
    $resultado = mysqli_query($conexion, $query);

    $municipios = array();

    while($row = mysqli_fetch_assoc($resultado)){
        $municipios[] = array(
            "id" => $row['id_municipio'],
            "nombre" => $row['municipio']
        );
    }

    echo json_encode($municipios);

    mysqli_close($conexion);
}

?>