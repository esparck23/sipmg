<?php

include 'conexion_db.php'; 

    $query = "SELECT * FROM organismos";
    $resultado = mysqli_query($conexion, $query);

    $organismos = array();

    while($row = mysqli_fetch_assoc($resultado)){
        $organismos[] = array(
            "id" => $row['organismo_id'],
            "nombre" => $row['nombre']
        );
    }

    echo json_encode($organismos);

    mysqli_close($conexion);

?>