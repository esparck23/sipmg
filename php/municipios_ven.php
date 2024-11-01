<?php

include 'conexion_db.php';

$estado =  $_GET['estado'];

$query = "SELECT id_municipio, municipio, estado FROM municipios, estados WHERE estados.id_estado = municipios.id_estado AND estados.estado = '$estado' ORDER BY municipio";
$resultado = mysqli_query($conexion, $query);

$municipios = array();

while($row = mysqli_fetch_assoc($resultado)){
    $municipios[] = array(
        "id" => $row['id_municipio'],
        "municipio" => $row['municipio'],
        "estado" => $row['estado']
    );
}

echo json_encode($municipios);

mysqli_close($conexion);

?>