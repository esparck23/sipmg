<?php
    ob_start();
    include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $codigo = trim($_POST['codigo_organismo']);
        $nombre = trim($_POST['nombre']);
        $descripcion = trim($_POST['descripcion']);
        $telefono = trim($_POST['telefono']);
        $correo = trim($_POST['correo']);
        $estado = trim($_POST['estado']);
        $municipio = trim($_POST['municipio']);
        $direccion = trim($_POST['direccion']);

        $sql = "INSERT INTO direcciones (estado, municipio, direccion) VALUES ('$estado', '$municipio','$direccion')";
        $conexion->query($sql);

        if($conexion->query($sql)){
            //si es correcta la insercion traemos la direccion_id para asociarlo a su organismo correspondiente
            $sql_direccion_id = "SELECT direccion_id
                FROM    direcciones
                WHERE   direccion_id = (SELECT MAX(direccion_id)
                FROM    direcciones)";

            $result= mysqli_query($conexion,$sql_direccion_id);

            //traemos el ultimo ID DATOS DE LA DIRECCION para asociarlo a ORGANISMO
            $row = mysqli_fetch_row($result);
            if ($row) {
                $d_id = trim($row[0]);  
            }
                $sqlorg = "INSERT INTO organismos (nombre, codigo, descripcion, telefono, correo, direccion_idfk) VALUES ('$nombre', '$codigo','$descripcion','$telefono','$correo','$d_id')";
                $res = $conexion->query($sqlorg);

                if ($res) {
                    header("Location: organismos.php");
                } else{
                    echo "error:registro_organismo";
                }
        } else{
            echo "error:registro_direccion";
        }
    } else {
        echo "error:registro_general";
    }

    
    ob_end_flush();
?>