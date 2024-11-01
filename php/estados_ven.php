<?php

include 'conexion_db.php'; 

$query = "SELECT id_estado, estado FROM estados ORDER BY estado";
$resultado = mysqli_query($conexion, $query);

// while($row = mysqli_fetch_assoc($resultado)){
//     echo "<option value='".$row['id_estado']."'>".$row['estado']."</option>";
// }

$estados = array();

while($row = mysqli_fetch_assoc($resultado)){
    $estados[] = array(
        "id" => $row['id_estado'],
        "nombre" => $row['estado']
    );
}

echo json_encode($estados);

mysqli_close($conexion);

?>