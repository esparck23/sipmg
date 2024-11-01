<?php

    include_once 'conexion_db.php';
        
    $user = trim($_POST['usuario']);
    $con = trim($_POST['clave']);
    
    $sql = "SELECT
        f.funcionario_id,
        f.cedula,
        f.nombre_completo,
        f.credencial,
        f.fecha_nacimiento,
        f.usuario,
        f.correo,
        f.clave,
        f.rol_idpk,
        r.nombre
        FROM
            (funcionarios f INNER JOIN roles r ON f.rol_idpk = r.rol_id)
        WHERE f.usuario = '$user' AND f.clave = '$con'";

    $result = mysqli_query($conexion,$sql);


    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_row($result);
        
        if (!isset($_SESSION['r_usuario'])) {

            session_start();
            // TIPO DE USUARIO
            $var = json_encode($row[8]);
            $_SESSION['r_usuario'] = $var;
            $e = $_SESSION['r_usuario'];
            $r_usuario = $e;
            
            // NOMBRE TIPO DE USUARIO = ADMINISTRADOR/CONSULTADOR
            $var = json_encode($row[9]);
            $_SESSION['nombre_rol'] = $var;
            $tu = $_SESSION['nombre_rol'];
            $nombre_rol = $tu;

            // NOMBRE COMPLETO DEL USUARIO
            $nom = json_encode($row[2]);
            $_SESSION['nombre'] = $nom;
            $n = $_SESSION['nombre'];
            $usuario_nombre = $n;
             
            header("location: consulta.php");
           //traslado a la pantalla principal
        }
    } else {
        header("location: ../index.php?error=1");
    }
?>