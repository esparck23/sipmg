<?php

include 'conexion_db.php'; 

    $query = "SELECT * FROM delitos";
    $resultado = mysqli_query($conexion, $query);

    $delitos = array();

    while($row = mysqli_fetch_assoc($resultado)){
        $delitos[] = array(
            "id" => $row['delito_id'],
            "nombre" => $row['nombre']
        );
    }

    echo json_encode($delitos);

    mysqli_close($conexion);

?>