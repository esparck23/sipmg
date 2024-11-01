<?php
    // Include the database conexionection file
    require_once 'conexion_db.php';

    function obtenerNombreEstadoPorId($estadoId) {
        global $conexion;
        $sql = "SELECT estado FROM estados WHERE id_estado = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $estadoId);
        $stmt->execute();
        $stmt->bind_result($NombreEstado);
        $stmt->fetch();
        $stmt->close();
        return $NombreEstado;
    }

    function obtenerNombreMunicipioPorId($municipioId) {
        global $conexion;
        $sql = "SELECT municipio FROM municipios WHERE id_municipio = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('i', $municipioId);
        $stmt->execute();
        $stmt->bind_result($NombreMunicipio);
        $stmt->fetch();
        $stmt->close();
        return $NombreMunicipio;
    }

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // DATOS DE LA DETENCION
        $expedientes = $_POST['expediente'] ?? [];
        $fechas_ingreso = $_POST['f_ingreso'] ?? [];
        $lugares_detencion = $_POST['lugar_detencion'] ?? [];
        $detenidos = $_POST['detenido'] ?? [];
        $descripciones_detencion = $_POST['descripcion_detencion'] ?? [];
        $estados = $_POST['estado'] ?? [];
        $municipios = $_POST['municipio'] ?? [];
        $delitos = $_POST['delito'] ?? [];
        $organismos = $_POST['organismo'] ?? [];
        $direcciones = $_POST['direccion_detencion'] ?? [];


        // Check for duplicate detainee selections
        $uniqueDetainees = [];
        foreach ($detenidos as $detainee) {
            if (in_array($detainee, $uniqueDetainees)) {
                header("location:registro_detenciones.php?msj=4");
                exit;
            } else {
                $uniqueDetainees[] = $detainee;
            }
        }


        // Begin transaction
        $conexion->begin_transaction();

        try {
            
            ################################# BLOQUE DETENCIONES ###################################################

            // Prepare SQL statement for detentions table
            $sql_detenciones = "INSERT INTO detenciones (numero, estatus, organismo_idfk, delito_idfk, detenido_idfk) VALUES (?, 'DETENIDO', ?, ?, ?)";
            $stmt_detenciones = $conexion->prepare($sql_detenciones);

            // Prepare SQL statement for addresses table
            $sql_direcciones = "INSERT INTO direcciones (estado, municipio, direccion) VALUES (?, ?, ?)";
            $stmt_direcciones = $conexion->prepare($sql_direcciones);

            // Prepare SQL statement for detalle_detenciones table
            $sql_detalle_detenciones = "INSERT INTO detalle_detenciones (fecha_ingreso, descripcion, lugar, direccion_idfk, detencion_idfk) VALUES (?, ?, ?, ?, ?)";
            $stmt_detalle_detenciones = $conexion->prepare($sql_detalle_detenciones);


            ## ITERADOR


            // Loop through each set of form data
            for ($i = 0; $i < count($expedientes); $i++) {

                ########################### INSERCION DATOS DETENCIONES ######################################
                // Get the names of the state and municipality
                $nombre_estado = obtenerNombreEstadoPorId($estados[$i]);
                $nombre_municipio = obtenerNombreMunicipioPorId($municipios[$i]);

                // Insert into addresses table
                $stmt_direcciones->bind_param('sss', $nombre_estado, $nombre_municipio, $direcciones[$i]);
                $stmt_direcciones->execute();
                $direccion_id = $stmt_direcciones->insert_id;

                // Insert into detentions table
                $stmt_detenciones->bind_param('siii', $expedientes[$i], $organismos[$i], $delitos[$i], $detenidos[$i]);
                $stmt_detenciones->execute();
                $detencion_id = $stmt_detenciones->insert_id;

                // Insert into detalle_detenciones table
                $stmt_detalle_detenciones->bind_param('sssii', $fechas_ingreso[$i], $descripciones_detencion[$i], $lugares_detencion[$i], $direccion_id, $detencion_id);
                $stmt_detalle_detenciones->execute();
            }

            ################################# FIN BLOQUE DETENCIONES ###################################################

            // Commit transaction
            $conexion->commit();

            header("location:registro_detenciones.php?msj=1");

        } catch (Exception $e) {
            // Rollback transaction on error
            $conexion->rollback();
            echo "Error: " . $e->getMessage();
            header("location:registro_detenciones.php?msj=4");
        } finally {
            $stmt_detenciones->close();
            $stmt_direcciones->close();
            $stmt_detalle_detenciones->close();
            $conexion->close();
        }
    }
?>
