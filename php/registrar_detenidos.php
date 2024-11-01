<?php
// Include the database conexionection file
require_once 'conexion_db.php';

function obtenerNombreEstadoPorIdDetenido($estadoDetenidoId) {
    global $conexion;
    $sql = "SELECT estado FROM estados WHERE id_estado = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $estadoDetenidoId);
    $stmt->execute();
    $stmt->bind_result($NombreEstadoDetenido);
    $stmt->fetch();
    $stmt->close();
    return $NombreEstadoDetenido;
}

function obtenerNombreMunicipioPorIdDetenido($municipioIdDetenido) {
    global $conexion;
    $sql = "SELECT municipio FROM municipios WHERE id_municipio = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('i', $municipioIdDetenido);
    $stmt->execute();
    $stmt->bind_result($NombreMunicipioDetenido);
    $stmt->fetch();
    $stmt->close();
    return $NombreMunicipioDetenido;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // RECIBIENDO Y LIMPIANDO LA DATA

    // DATOS DEL DETENIDO
    $ciudadanos = $_POST['nacionalidad'] ?? [];
    $cedulas = $_POST['cedula'] ?? [];
    $p_nombres = $_POST['p_nombre'] ?? [];
    $s_nombres = $_POST['s_nombre'] ?? [];
    $p_apellidos = $_POST['p_apellido'] ?? [];
    $s_apellidos = $_POST['s_apellido'] ?? [];
    $f_nacimientos = $_POST['fecha_nacimiento'] ?? [];
    $edades = $_POST['edad'] ?? [];
    $estados_detenido = $_POST['estado_detenido'] ?? [];
    $municipios_detenido = $_POST['municipio_detenido'] ?? [];
    $direcciones_detenido = $_POST['direccion_detenido'] ?? [];
    $sexos = $_POST['sexo'] ?? [];


    // fotos
    if (isset($_FILES['foto']['name'])) {
        $nombreArchivos = $_FILES['foto']['name'] ?? [];
        $tipoArchivos = $_FILES['foto']['type'] ?? [];
        $tamanioArchivos = $_FILES['foto']['size'] ?? [];
        $rutaTempArchivos = $_FILES['foto']['tmp_name'] ?? [];

        // Definir la carpeta donde se almacenarán las imágenes
        $carpetaDestino = __DIR__ .'\fotosdetenido\\';

    }else {
        echo 'No se ha enviado ningún archivo.';
    }

    // Begin transaction
    $conexion->begin_transaction();

    try {
        ################################# BLOQUE DETENIDOS ###################################################

         // Prepare SQL statement for detenidos table
         $sql_detenidos = "INSERT INTO detenidos (cedula, ciudadano_idfk) VALUES (?, ?)";
         $stmt_detenidos = $conexion->prepare($sql_detenidos);

        // // Prepare SQL statement for addresses table for arrests
        $sql_direcciones_detenidos = "INSERT INTO direcciones (estado, municipio, direccion) VALUES (?, ?, ?)";
        $stmt_direcciones_detenidos = $conexion->prepare($sql_direcciones_detenidos);

        // // Prepare SQL statement for detalle_arrests table
        $sql_detalle_detenidos = "INSERT INTO detalle_detenidos (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, fecha_nacimiento, edad, sexo, ruta_foto, nombre_foto, detenido_idfk, direccion_idfk) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_detalle_detenidos = $conexion->prepare($sql_detalle_detenidos);
    
        ################################# FIN BLOQUE DETENIDOS #################################################


         ## ITERADOR


        // Loop through each set of form data
        for ($i = 0; $i < count($ciudadanos); $i++) {

            ########################### INSERCION DATOS DETENIDOS ######################################

            // Obtener los nombres del estado y del municipio para las detenciones
            $nombre_estado_detenido = obtenerNombreEstadoPorIdDetenido($estados_detenido[$i]);
            $nombre_municipio_detenido = obtenerNombreMunicipioPorIdDetenido($municipios_detenido[$i]);

            ####################### ESPACIO DE LAS FOTOS DE LOS DETENIDOS ##################################
                $nombreArchivo = basename($nombreArchivos[$i]);
                $nombreUnico = uniqid() . '_' . $nombreArchivo;
                $rutaDestino = $carpetaDestino . $nombreUnico;


                 // Mover la imagen a la carpeta de destino
                 if (move_uploaded_file($rutaTempArchivos[$i], $rutaDestino)) {
                    $nombreImagenDB = $conexion->real_escape_string($nombreUnico);
                    $rutaImagenDB = $conexion->real_escape_string($rutaDestino);
                 } else {
                    $rutaImagenDB = '';
                    $nombreImagenDB = '';
                    echo "Error al guardar la imagen en la base de datos: " . $conexion->error;
                }

            // Insert into addresses table
            $stmt_direcciones_detenidos->bind_param('sss', $nombre_estado_detenido, $nombre_municipio_detenido, $direcciones_detenido[$i]);
            $stmt_direcciones_detenidos->execute();
            $direccion_detenido_id = $stmt_direcciones_detenidos->insert_id;

            // Insert into detentions table
            $stmt_detenidos->bind_param('ss',$cedulas[$i], $ciudadanos[$i]);
            $stmt_detenidos->execute();
            $detenido_id = $stmt_detenidos->insert_id;

            // Insert into detalle_detenidos table
            $stmt_detalle_detenidos->bind_param('sssssssssss', $p_nombres[$i], $s_nombres[$i], $p_apellidos[$i], $s_apellidos[$i], $f_nacimientos[$i], $edades[$i], $sexos[$i], $rutaImagenDB, $nombreImagenDB, $detenido_id, $direccion_detenido_id);
            $stmt_detalle_detenidos->execute();

            // Debug print
            //error_log("Debug: Fecha de nacimiento procesada: " . $f_nacimientos);
        }

        // Commit transaction
        $conexion->commit();
        echo "transacciones realizadas";
        header("location:registro_detenidos.php?msj=1");

    } catch (Exception $e) {
        // Rollback transaction on error
        $conexion->rollback();
        echo "Error: " . $e->getMessage();
        header("location:registro_detenidos.php?msj=2");
    } finally {
        // Close statements and conexion
        $stmt_detenidos->close();
        $stmt_direcciones_detenidos->close();
        $stmt_detalle_detenidos->close();
        $conexion->close();
    }
}
?>
