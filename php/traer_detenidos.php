<?php

include 'conexion_db.php'; 

    $query = "SELECT d.*, dd.*
                FROM detenidos d
                JOIN detalle_detenidos dd ON d.detenido_id = dd.detenido_idfk
                WHERE d.oculto = 0
                AND NOT EXISTS (
                    SELECT 1
                    FROM detenciones det
                    WHERE det.detenido_idfk = d.detenido_id
                    AND det.estatus = 'DETENIDO'
                )";
    $resultado = mysqli_query($conexion, $query);

    $detenidos = array();

    while($row = mysqli_fetch_assoc($resultado)){
        $nac = ($row['ciudadano_idfk'] == "1") ? "V-" : "E-";
        $detenidos[] = array(
            "id" => $row['detenido_id'],
            "nombre" => $row['primer_nombre'],
            "apellido" => $row['primer_apellido'],
            "nacionalidad" => $nac,
            "cedula" => $row['cedula']
        );
    }

    echo json_encode($detenidos);

    mysqli_close($conexion);

?>