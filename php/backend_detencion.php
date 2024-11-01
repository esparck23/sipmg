<?php
require_once 'conexion_db.php'; // CONEXION A LA BASE DE DATOS

    $tipo = "";
    $ultimo_id = "";
    $id = "";
    // VALIDACION DEL TIPO DE OPERACION A EJECUTAR PARA TABLA DETENIDOS
if (isset($_REQUEST["tipo"]) > 0 && isset($_REQUEST["tipo"]) != '') {
    $tipo = trim($_REQUEST["tipo"]);

}
if (isset($_REQUEST["ultimo_id"]) > 0 && isset($_REQUEST["ultimo_id"]) != '') {
    $ultimo_id = trim($_REQUEST["ultimo_id"]);

}
if (isset($_REQUEST["id"]) > 0 && isset($_REQUEST["id"]) != '') {
    $id = trim($_REQUEST["id"]);

}

if (isset($_REQUEST["detenido"]) > 0 && isset($_REQUEST["detenido"]) != '') {
    $detenido_id = trim($_REQUEST["detenido"]);

}
    if ($_REQUEST["tipo"] == "registro_detencion") {

        // INICIO VALORES GENERAL DETENCION ########

        $numero = $_POST['expediente'];
        $estatus = "DETENIDO";
        $organismo = $_POST['organismo'];
        $delito = $_POST['delito'];
        $direccion_detencion = $_POST['direccion_detencion'];
        $estado = $_POST['estado'];
        $municipio = $_POST['municipio'];
        $f_ingreso = $_POST['f_ingreso'];
        $lugar_detencion = $_POST['lugar_detencion'];
        $descripcion_detencion = $_POST['descripcion_detencion'];
        
        
        // FIN VALORES GENERAL DETENCION ########


        // REGISTRAMOS LA DETENCION A CONTINUACION #####
        $query = "INSERT INTO detenciones
                        (numero,
                        estatus,
                        organismo_idfk,
                        delito_idfk,
                        detenido_idfk)
                VALUES ('$numero',
                        '$estatus',
                        '$organismo',
                        '$delito',
                        '$id')"; // ID DEL GET
        $res = $conexion->query($query);


        // SI ES EFECTIVA LA INSERCION DE LA DETENCION
        if($res){

            // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
            $sql_dete_id = "SELECT detencion_id
                FROM    detenciones
                WHERE   detencion_id = (SELECT MAX(detencion_id)
                FROM    detenciones)";

            $result= mysqli_query($conexion,$sql_dete_id);

            // TRAEMOS EL ULTIMO ID CON LA SIGUIENTE LINEA DE CODIGO
            $row = mysqli_fetch_row($result);
            if ($row) {
                $dete_id = trim($row[0]);  
            }
        }
        else {
            echo "error:insertar_detencion";
        } 
        // PROCEDEMOS A REGISTRAR LA DIRECCION DE LA DETENCION ########

        $q_direccion = "INSERT INTO direcciones
                        (estado,
                        municipio,
                        direccion)
                VALUES ('$estado',
                        '$municipio',
                        '$direccion_detencion')";
        $res = $conexion->query($q_direccion);

        if($res){

            // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
            $sql_dir_id = "SELECT direccion_id
                FROM    direcciones
                WHERE   direccion_id = (SELECT MAX(direccion_id)
                FROM    direcciones)";

            $result= mysqli_query($conexion,$sql_dir_id);

            // TRAEMOS EL ULTIMO ID CON LA SIGUIENTE LINEA DE CODIGO
            $row = mysqli_fetch_row($result);
            if ($row) {
                $dir_id = trim($row[0]);  
            }
        }
        else {
            echo "error:insertar_direccion";
        }                

        // REGISTRAMOS EL DETALLE DE LA DETENCION ########
        $query = "INSERT INTO detalle_detenciones
                        (fecha_ingreso,
                        descripcion,
                        lugar,
                        direccion_idfk,
                        detencion_idfk)
                VALUES ('$f_ingreso',
                        '$descripcion_detencion',
                        '$lugar_detencion',
                        '$dir_id',
                        '$dete_id')";              
        $res = $conexion->query($query);
        
        if ($res) {
            header("registro_detenido.php");
        }
        else {
            echo "error:insertar_detalle_detencion";
        }

        // REDIRECCIONAMOS A LA PANTALLA PRINCIPAL
        header("location:consulta.php");

    } elseif ($_REQUEST["tipo"] == "registro_detencion_porlista") {

                // INICIO VALORES GENERAL DETENCION ########

                $numero = $_POST['expediente'];
                $estatus = "DETENIDO";
                $organismo = $_POST['organismo'];
                $delito = $_POST['delito'];
                $direccion_detencion = $_POST['direccion_detencion'];
                $estado = $_POST['estado'];
                $municipio = $_POST['municipio'];
                $f_ingreso = $_POST['f_ingreso'];
                $lugar_detencion = $_POST['lugar_detencion'];
                $descripcion_detencion = $_POST['descripcion_detencion'];
                $detenido_id = $_POST['detenido'];
                
                
                // FIN VALORES GENERAL DETENCION ########
        
        
                // REGISTRAMOS LA DETENCION A CONTINUACION #####
                $query = "INSERT INTO detenciones
                                (numero,
                                estatus,
                                organismo_idfk,
                                delito_idfk,
                                detenido_idfk)
                        VALUES ('$numero',
                                '$estatus',
                                '$organismo',
                                '$delito',
                                '$detenido_id')"; // ID DEL GET
                $res = $conexion->query($query);
        
        
                //SI ES EFECTIVA LA INSERCION DE LA DETENCION
                if($res){
        
                    // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
                    $sql_dete_id = "SELECT detencion_id
                        FROM    detenciones
                        WHERE   detencion_id = (SELECT MAX(detencion_id)
                        FROM    detenciones)";
        
                    $result= mysqli_query($conexion,$sql_dete_id);
        
                    // TRAEMOS EL ULTIMO ID CON LA SIGUIENTE LINEA DE CODIGO
                    $row = mysqli_fetch_row($result);
                    if ($row) {
                        $dete_id = trim($row[0]);  
                    }
                }
                else {
                    echo "error:insertar_detencion_lista";
                } 
                // PROCEDEMOS A REGISTRAR LA DIRECCION DE LA DETENCION ########
        
                $q_direccion = "INSERT INTO direcciones
                                (estado,
                                municipio,
                                direccion)
                        VALUES ('$estado',
                                '$municipio',
                                '$direccion_detencion')";
                $res = $conexion->query($q_direccion);
        
                if($res){
        
                    // SI ES EFECTIVA, SE RECOGE EL ULTIMO ID INSERTADO
                    $sql_dir_id = "SELECT direccion_id
                        FROM    direcciones
                        WHERE   direccion_id = (SELECT MAX(direccion_id)
                        FROM    direcciones)";
        
                    $result= mysqli_query($conexion,$sql_dir_id);
        
                    // TRAEMOS EL ULTIMO ID CON LA SIGUIENTE LINEA DE CODIGO
                    $row = mysqli_fetch_row($result);
                    if ($row) {
                        $dir_id = trim($row[0]);  
                    }
                }
                else {
                    echo "error:insertar_direccion_lista";
                }                
        
                // REGISTRAMOS EL DETALLE DE LA DETENCION ########
                $query = "INSERT INTO detalle_detenciones
                                (fecha_ingreso,
                                descripcion,
                                lugar,
                                direccion_idfk,
                                detencion_idfk)
                        VALUES ('$f_ingreso',
                                '$descripcion_detencion',
                                '$lugar_detencion',
                                '$dir_id',
                                '$dete_id')";              
                $res = $conexion->query($query);
                
                if ($res) {
                    header("location:lista_detenciones.php");
                }
                else {
                    echo "error:insertar_detalle_detencion_condetenido_lista";
                }

        
    } else {
        echo "error:backend_detencion_general";
    }
    
?>