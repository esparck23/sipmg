<?php
include 'conexion_db.php'; // CONEXION A LA BASE DE DATOS
    if (session_start()){

        if (isset($_SESSION['r_usuario'])){
            $r_usuario = json_decode($_SESSION['r_usuario']);
        }
    }
    // VALIDACION DEL TIPO DE OPERACION A EJECUTAR PARA TABLA INTERNO_DETENIDO
    if (isset($_POST['tipo']) > 0 && isset($_POST['tipo']) != '') {
        $tipo = trim($_POST['tipo']);
    }
    if (isset($_POST['id']) > 0 && isset($_POST['id']) != '') {
        $id = trim($_POST['id']);
    }


    if ($tipo == 'buscar_interno') {

        // INICIO DE VALIDACIONES PARA INCLUIR UNA PAGINACION -SIN BUSQUEDA -SIN LISTA DE LOTES PAGINADOS
        $limite = 5;
        $cuenta = 0;
        $inicio = 0;
        $nuevoInicio = 0;
        if (isset($_POST['inicio'])) {

            $inicio = $_POST['inicio'];
            $nuevoInicio = ($inicio - 1)*$limite;
        }
        $sql = "SELECT 
                    id.interno_id,
                    id.fecha_ingreso, 
                    id.fecha_egreso, 
                    id.descripcion,
                    id.lugar_detencion, 
                    id.datof_idpk AS datof_id, 
                    d.codigo_delito,
                    d.delito_id, 
                    d.nombre, 
                    d.descripcion AS detalleDelito,
                    o.organismo_id,
                    o.codigo_organismo, 
                    o.descripcion AS detalleOrganismo, 
                    o.persona_contacto 
                FROM ((interno_detenido id INNER JOIN delito d
                ON id.codigod_idpk = d.delito_id) INNER JOIN organismo o
                ON id.codigo_org_idpk = o.organismo_id)
                WHERE id.datof_idpk = '$id' ORDER BY id.datof_idpk DESC LIMIT $inicio,$limite";


        $result = mysqli_query($conexion,$sql);
        $numero = 0;
        if(mysqli_num_rows($result) > 0){ // SE IMPRIME UNA TABLA COMPLETA EN HTML Y PHP PARA MOSTRAR LOS REGISTROS ASOCIADOS A UNA CEDULA PREVIAMENTE CONSULTADA
            
            // SE CONSULTA EL TOTAL DE REGISTROS PARA LA PAGINACION
            $sql_total = "SELECT interno_id FROM interno_detenido WHERE datof_idpk = '$id'";
            $result_total_rows = mysqli_query($conexion,$sql_total);
            $cuenta = mysqli_num_rows($result_total_rows); // NUMERO DE REGISTROS TOTAL EN VARIABLE CUENTA

            
            if ($r_usuario != 2) { // SI EL USUARIO ES "ADMINISTRADOR" SE IMPRIME CON ACCIONES DE EDITAR Y ELIMINAR
                echo '<div class="row"><div class="card-panel"><div class="row"><h4 class="header_h">Documentación de interno detenido</h4></div><table class="highlight" id="tablaRegistroInterno"><thead><tr><th>Nro.</th><th>Fecha de ingreso</th><th>Fecha de egreso</th><th>Descipción</th><th>Organismo</th><th>Lugar de detención</th><th>Acciones</th></thead><tbody>';
                foreach($result as $res):
                    $numero++;
                    if ($res['fecha_egreso'] == '') {
                        echo "<tr><td>".$numero."</td><td>".date("d/m/Y", strtotime($res['fecha_ingreso']))."</td><td>".$res['fecha_egreso']."</td><td>".$res['descripcion']."</td><td>".$res['detalleOrganismo']."</td><td>".$res['lugar_detencion']."</td><td><a data-target='modalGeneral'class='modal-trigger' id='detalle_interno_btn' href='javascript:void(0)'onclick='DetalleInterno(".trim($res['interno_id']).")'>Ver detalle</a></br><a data-target='modalGeneral'class='modal-trigger' id='editar_interno_btn' href='javascript:void(0)' onclick='EditarInterno(".trim($res['interno_id']).")'>Editar</a></br><a data-target='modalGeneral'class='modal-trigger' id='eliminar_interno_btn' href='javascript:void(0)'onclick='EliminarInterno(".trim($res['interno_id']).")'>Eliminar</a></td></tr>";    
                    }
                    else{
                        echo "<tr><td>".$numero."</td><td>".date("d/m/Y", strtotime($res['fecha_ingreso']))."</td><td>".date("d/m/Y", strtotime($res['fecha_egreso']))."</td><td>".$res['descripcion']."</td><td>".$res['detalleOrganismo']."</td><td>".$res['lugar_detencion']."</td><td><a data-target='modalGeneral'class='modal-trigger' id='detalle_interno_btn' href='javascript:void(0)'onclick='DetalleInterno(".trim($res['interno_id']).")'>Ver detalle</a></br><a data-target='modalGeneral'class='modal-trigger' id='editar_interno_btn' href='javascript:void(0)' onclick='EditarInterno(".trim($res['interno_id']).")'>Editar</a></br><a data-target='modalGeneral'class='modal-trigger' id='eliminar_interno_btn' href='javascript:void(0)'onclick='EliminarInterno(".trim($res['interno_id']).")'>Eliminar</a></td></tr>";    
                    }
                endforeach;
                    echo "</tbody></table><input type='hidden' id='num_reg' value='".$cuenta."'></br><div id='paginador'></div></div></div>";
                    
            } else {
                echo '<div class="row"><div class="card-panel"><div class="row"><h4 class="header_h">Documentación de interno detenido</h4></div><table class="highlight" id="tablaRegistroInterno"><thead><tr><th>Nro.</th><th>Fecha de ingreso</th><th>Fecha de egreso</th><th>Descipción</th><th>Organismo</th><th>Lugar de detención</th><th>Acciones</th></thead><tbody>';
                foreach($result as $res):
                    if ($res['fecha_egreso'] == '') {
                        echo "<tr><td>".$numero."</td><td>".date("d/m/Y", strtotime($res['fecha_ingreso']))."</td><td>".$res['fecha_egreso']."</td><td>".$res['descripcion']."</td><td>".$res['detalleOrganismo']."</td><td>".$res['lugar_detencion']."</td><td><a data-target='modalGeneral'class='modal-trigger' id='detalle_interno_btn' href='javascript:void(0)'onclick='DetalleInterno(".trim($res['interno_id']).")'>Ver detalle</a></td></tr>";    
                    }
                    else{
                        echo "<tr><td>".$numero."</td><td>".date("d/m/Y", strtotime($res['fecha_ingreso']))."</td><td>".date("d/m/Y", strtotime($res['fecha_egreso']))."</td><td>".$res['descripcion']."</td><td>".$res['detalleOrganismo']."</td><td>".$res['lugar_detencion']."</td><td><a data-target='modalGeneral'class='modal-trigger' id='detalle_interno_btn' href='javascript:void(0)'onclick='DetalleInterno(".trim($res['interno_id']).")'>Ver detalle</a></td></tr>";    
                    }
                    $numero++; endforeach;
                    echo "</tbody></table><input type='hidden' id='num_reg' value='".$cuenta."'></br><div id='paginador'></div></div></div>";
                
            }
                
        }

    } elseif ($tipo == 'registro_interno') { // VALIDA EL TIPO DE OPERACION A EJECUTAR

           
            $f_i = trim($_POST['f_ingreso']);
            $f_e = trim($_POST['f_egreso']);
            $des_e = trim($_POST['descripcion_egreso']);
            $l_d = trim($_POST['lugar_detencion']);
            $de = trim($_POST['descripcion_interno']);
            $d_id = trim($_POST['delito']);
            $o_id = trim($_POST['organismo']);
            $df_if = trim($_POST['id']);

            $sql = "INSERT INTO interno_detenido (
                        fecha_ingreso,
                        fecha_egreso,
                        descripcion_egreso,
                        descripcion,
                        lugar_detencion,
                        datof_idpk,
                        codigod_idpk,
                        codigo_org_idpk)
                    VALUES( '$f_i',
                            '$f_e',
                            '$des_e',
                            '$de',
                            '$l_d',
                            '$df_if',
                            '$d_id',
                            '$o_id')";
                            
            $ejecutar = mysqli_query($conexion, $sql);
                // SE EJECUTA UNA SENTENCIA PARA REGISTRAR UNA NUEVA DOCUMENTACION DE INTERNO DETENIDO
            if ($ejecutar > 0){
                header("location:consulta.php"); 
            }else {
                header("location:consulta.php");
            } // ESTOS HEADERS DIRIGEN A UNA PAGINA DE EXITO O ERROR SEGUN SEA EL CASO

    } elseif ($tipo == 'detalle_interno') {

        $sql = "SELECT
                    id.fecha_ingreso, 
                    id.fecha_egreso, 
                    id.descripcion_egreso, 
                    id.descripcion,
                    id.lugar_detencion,
                    id.datof_idpk AS datof_id, 
                    d.codigo_delito,
                    d.delito_id, 
                    d.nombre AS nombreDelito, 
                    d.descripcion AS detalleDelito,
                    o.organismo_id, 
                    o.codigo_organismo, 
                    o.descripcion AS detalleOrganismo, 
                    o.persona_contacto AS PersonaOrganismo
            FROM interno_detenido id,
                delito d, organismo o
            WHERE id.interno_id = '$id'
            AND id.codigod_idpk = d.delito_id
            AND id.codigo_org_idpk = o.organismo_id";

            $result = mysqli_query($conexion,$sql);

            if(mysqli_num_rows($result) > 0){ // SE EJECUTA UNA SENTENCIA PARA BUSCAR DETALLE DE INTERNO DETENIDO
                foreach($result as $res):
                        echo json_encode($res);
                endforeach;
            } else{
                echo json_encode('error');
                exit;
            }

    } elseif ($tipo == 'editar_interno') {

        $fi = trim($_POST['fi']);
        $fe = trim($_POST['fe']);
        $dese = trim($_POST['dese']);
        $ld = trim($_POST['ld']);
        $di = trim($_POST['di']);
        $de  = trim($_POST['de']);
        $or = trim($_POST['or']);
        $df_id = trim($_POST['df_id']);
        
        $sql=   "UPDATE
                    interno_detenido
                SET
                    fecha_ingreso = '$fi',
                    fecha_egreso = '$fe',
                    descripcion_egreso = '$dese',
                    descripcion = '$di',
                    lugar_detencion = '$ld',
                    datof_idpk = '$df_id',
                    codigod_idpk = '$de',
                    codigo_org_idpk = '$or'
                WHERE
                    interno_id = '$id'";

        $ejecutar = mysqli_query($conexion, $sql); // SE EJECUTA UNA SENTENCIA PARA MODIFICAR DATOS DE INTERNO DETENIDO SEGUN ELECCION DEL CONSULTOR

        if ($ejecutar){
            echo "exito";
        } else {
            echo "error";
        }

    } elseif ($tipo == 'eliminar_interno') {
        $sql="DELETE
              FROM
                interno_detenido
              WHERE
                interno_id = '$id'";

        $ejecutar=mysqli_query($conexion,$sql);

        if ($ejecutar){
            echo "exito";
        }
    } elseif ($tipo == 'paginacion') {
        # code...
    }
?>