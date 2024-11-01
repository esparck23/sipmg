<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // chequear que no tenga detenciones asociadas
    $consulta = "SELECT * FROM detenciones WHERE organismo_idfk = $id";
    $res = $conexion->query($consulta);
    if (mysqli_num_rows($res) > 0) {
        header('Location: organismos.php?msj=2');
    } else {
        $sql = "DELETE FROM organismos WHERE organismo_id = $id"; // si no existe registros HACE EL DELETE
        $res = $conexion->query($sql);
        if ($res) {
            header('Location: organismos.php?msj=1');
        }
    }
}
?>