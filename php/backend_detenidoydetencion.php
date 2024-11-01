<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

    // INICIO VALORES GENERAL ########
    $estado = $_REQUEST['estado'];
    $municipio = $_REQUEST['municipio'];
    $direccion = $_REQUEST['direccion'];
    $nacionalidad = $_REQUEST['nacionalidad'];
    $cedula = $_REQUEST['cedula'];
    $p_nombre = $_REQUEST['p_nombre'];
    $s_nombre = $_REQUEST['s_nombre'];
    $p_apellido = $_REQUEST['p_apellido'];
    $s_apellido = $_REQUEST['s_apellido'];
    $fecha_n = $_REQUEST['fecha_n'];
    $edad = $_REQUEST['edad_calculada'];
    $sexo = $_REQUEST['sexo'];

    if (isset($_FILES['foto'])) {
        $nombreArchivo = $_FILES['foto']['name'];
        $tipoArchivo = $_FILES['foto']['type'];
        $tamanioArchivo = $_FILES['foto']['size'];
        $rutaTempArchivo = $_FILES['foto']['tmp_name'];

        // Definir la carpeta donde se almacenarán las imágenes
        //$carpetaDestino = './img/';
        $carpetaDestino = __DIR__ .'\fotosdetenido\\';

        // Crear un nombre único para la imagen
        $nombreUnico = uniqid() . '_' . $nombreArchivo;

        // Ruta completa donde se almacenará la imagen
        $rutaDestino = $carpetaDestino . $nombreUnico;

        // Mover la imagen a la carpeta de destino
        move_uploaded_file($rutaTempArchivo, $rutaDestino);


        $nombreImagenDB = $conexion->real_escape_string($nombreUnico);
        $rutaImagenDB = $conexion->real_escape_string($rutaDestino);

    }else {
        echo 'No se ha enviado ningún archivo.';
    }
    // FIN VALORES GENERAL #######
     
    
    // INICIO INSERTAR DIRECCION  ########
    $query_direccion = "INSERT INTO direcciones
                                    (estado,
                                    municipio,
                                    direccion)
                        VALUES ('$estado',
                                '$municipio',
                                '$direccion')";
    $res = $conexion->query($query_direccion);

    if($res){

        // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
        $sql_direccion_id = "SELECT direccion_id
            FROM    direcciones
            WHERE   direccion_id = (SELECT MAX(direccion_id)
            FROM    direcciones)";

        $result= mysqli_query($conexion,$sql_direccion_id);

        // TRAEMOS EL ULTIMO ID CON LA SIGUIENTE LINEA DE CODIGO
        $row = mysqli_fetch_row($result);
        if ($row) {
            $dir_id = trim($row[0]);  
        }
        else {
            echo "error:direccion_detenido";
        }

        //FIN INSERTAR DIRECCION ######

        // INICIO INSERTAR DETENIDO EN TABLA DETENIDOS ######

        $sql = "INSERT INTO detenidos (cedula,
                                ciudadano_idfk)
            VALUES ('$cedula',
                    '$nacionalidad')";
        $rese = $conexion->query($sql);

        if ($rese) {

        // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
        $sql_detenido_id = "SELECT detenido_id
        FROM    detenidos
        WHERE   detenido_id = (SELECT MAX(detenido_id)
        FROM    detenidos)";

        $result= mysqli_query($conexion,$sql_detenido_id);

        // TRAEMOS EL ID DEL DETENIDO 
        $row = mysqli_fetch_row($result);
        if ($row) {
            $dete_id = trim($row[0]);  
        }
        else {
            echo "error:insertar_detenido";
        }
        // FIN INSERTAR DETENIDO EN TABLA DETENIDOS ######


        // INICIO INSERTAR DETALLE DETENIDO ######

        $sql =  "INSERT INTO detalle_detenidos(
            primer_nombre,
            segundo_nombre,
            primer_apellido,
            segundo_apellido,
            fecha_nacimiento,
            edad,
            sexo,
            nombre_foto,
            ruta_foto,
            detenido_idfk,
            direccion_idfk)
            VALUES('$p_nombre',
                '$s_nombre',
                '$p_apellido',
                '$s_apellido',
                '$fecha_n',
                '$edad',
                '$sexo',
                '$nombreUnico',
                '$rutaDestino',
                '$dete_id',
                '$dir_id'
            )";
            $result = $conexion->query($sql);

        if ($result) {
                header("location:registro_detencion.php?id=".$dete_id);
            } else{
                echo "error:insertar_detalle_detenido";
            }
        }
    }

// FIN INSERTAR DETALLE DETENIDO ######
// FIN TODO
?>