<?php
require_once('header.php');
include 'conexion_db.php';
    
    $detenido_id = 0;
    $detencion_id = 0;
    $pg = '';
    // obtener el ID del GET (id de la detencion DESDE LISTA DE DETENIDOS & ID del listado general de detenciones)
    if (isset($_GET['id']) != "" && isset($_GET['id']) > 0)  {
        $detencion_id = $_GET['id'];
    

        // obtener el ID del GET (id del detenido DESDE LISTA DE DETENIDOS)
        if (isset($_GET['dt']) != "" && isset($_GET['dt']) > 0) {
            $detenido_id = $_GET['dt'];
        }

        if (isset($_GET['pg']) != "") {
            $pg = $_GET['pg'];
        }

        if ($detenido_id == 0) {
        
            $sql = "SELECT detenciones.*, detalle_detenciones.*, direcciones.*, organismos.nombre AS nombre_organismo, delitos.nombre AS nombre_delito, detenidos.detenido_id
                FROM detenciones 
                LEFT JOIN detalle_detenciones ON detalle_detenciones.detencion_idfk = detenciones.detencion_id 
                LEFT JOIN detenidos ON detenciones.detenido_idfk = detenidos.detenido_id
                LEFT JOIN direcciones ON detalle_detenciones.direccion_idfk = direcciones.direccion_id
                LEFT JOIN organismos ON detenciones.organismo_idfk = organismos.organismo_id
                LEFT JOIN delitos ON detenciones.delito_idfk = delitos.delito_id
                WHERE detenciones.detencion_id = '$detencion_id'
                ORDER BY detenciones.detencion_id";
            $resultado_detencion = $conexion->query($sql);
            $row = $resultado_detencion->fetch_assoc();
        } else if ($detenido_id > 0){
        
            $sql = "SELECT detenciones.*, detalle_detenciones.*, direcciones.*, organismos.nombre AS nombre_organismo, delitos.nombre AS nombre_delito, detenidos.detenido_id
                FROM detenciones 
                JOIN detalle_detenciones ON detalle_detenciones.detencion_idfk = detenciones.detencion_id 
                JOIN detenidos ON detenciones.detenido_idfk = detenidos.detenido_id
                JOIN direcciones ON detalle_detenciones.direccion_idfk = direcciones.direccion_id
                JOIN organismos ON detenciones.organismo_idfk = organismos.organismo_id
                JOIN delitos ON detenciones.delito_idfk = delitos.delito_id
                WHERE detenidos.detenido_id = '$detenido_id' AND detenciones.detencion_id = '$detencion_id'
                ORDER BY detenciones.detencion_id";
            $resultado_detencion = $conexion->query($sql);
            $row = $resultado_detencion->fetch_assoc();
        }

?>
        <?php if (mysqli_num_rows( $resultado_detencion ) > 0) { ?>
        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                        <h4 class="header_h center"><b>Detalle de Datos de la Detención</b></h4>
                <div class="card-panel">
                    <div class="row">
                        <div class="col s4 m3 offset-m1">
                            <span class="helper-text"><b>Expediente</b></span>
                            <p><?= $row["numero"];?></p>
                        </div>
                        <div class="col s4 m4">
                            <span class="helper-text"><b>Estatus</b></span>
                            <?php if ($row["estatus"] === "EGRESADO") { ?>

                                <p><?= $row["estatus"];?>
                                <a data-target="modalVerEgresoDetencion" class="btn btn-floating waves-effect waves-light blue tooltipped modal-trigger" data-position="bottom" data-tooltip="Ver detalle del Egreso"><i class="material-icons">info</i></a></p>
                        
                            <?php } else {?>
                                <p><?= $row["estatus"];?></p>
                            <?php } ?>
                            </div>
                        <div class="col s4 m3">
                            <span class="helper-text"><b>Fecha de Ingreso</b></span>
                            <p><?= $row["fecha_ingreso"];?></p>
                        </div>
                    </div>
                    <div class="row"><br>
                        <div class="col s4 m2 offset-m1">
                            <span class="helper-text"><b>Delito</b></span>
                            <p><?= $row["nombre_delito"];?></p>
                        </div>
                        <div class="col s4 m8">
                            <span class="helper-text"><b>Descipción del delito/ aprehensión</b></span>
                            <p><?= $row["descripcion"];?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4 m3 offset-m1">
                            <span class="helper-text"><b>Lugar de Referencia</b></span>
                            <p><?= $row["lugar"];?></p>
                        </div>
                        <div class="col s4 m5">
                            <span class="helper-text"><b>Dirección de aprehensión</b></span>
                            <p><?php echo $dir = ($row["direccion"] != "") ? $row["direccion"].", ".$row["municipio"].", ".$row["estado"]."." : "N/A";?></p>
                        </div>
                        <div class="col s12 m3">
                            <span class="helper-text"><b>Organismo</b></span>
                            <p><?= $row["nombre_organismo"];?></p>
                        </div>
                    </div>
                    <br>
                    <?php if ($detenido_id == 0) { ?>
                    <div class="row"><br>
                        <div class="input-field col s6 m6 offset-m1">
                        <a href="lista_detenciones.php" class="waves-effect waves-light btn blue" title="Ir atrás" id="atras" style="color:#fff"><i class="material-icons right">arrow_back</i>ATRAS</a>
                        </div>
                    </div>
                    <?php } else { ?> 
                    <div class="row"><br>
                        <div class="input-field col s6 m6 offset-m1">
                        <a href="detenciones.php?id=<?= $detenido_id; ?>&pg=<?= $pg; ?>" class="waves-effect waves-light btn blue" title="Ir atrás" id="atras" style="color:#fff"><i class="material-icons right">arrow_back</i>ATRAS</a>
                        </div>
                    </div>
                    <?php } ?> 
                </div>
            </div>
            <div id="modalVerEgresoDetencion" class="modal">
                <div class="modal-content">
                    <h6 class="class header_h2 center"><b>DETALLE DEL EGRESO</b></h6><br>
                    <div class="container">
                        <div class="row">
                            <div class="col s12 m12">

                                <?php 
                                
                                $sql = "SELECT ed.fecha_egreso, ed.descripcion, te.nombre FROM egreso_detenciones ed, tipo_egresos te WHERE ed.detencion_idfk = $detencion_id AND ed.tipoegreso_idfk = te.tipoegreso_id";
                                $res = $conexion->query($sql);
                                $egreso = $res->fetch_assoc();
                                ?>
                                <div class="col s6 m4">
                                    <span class="helper-text"><b>Fecha del Egreso</b></span>
                                    <p><?= $egreso["fecha_egreso"];?></p>
                                </div>
                                <div class="col s6 m8">
                                    <span class="helper-text"><b>Tipo de Egreso</b></span>
                                    <p><?= $egreso["nombre"];?></p>
                                </div><br>
                                <div class="col s6 m12"><br>
                                    <span class="helper-text"><b>Descripción</b></span>
                                    <p><?= $egreso["descripcion"];?></p>
                                </div>
                                <div class="col s6 m12"><br>
                                    <a href="javascript:void(0)" class="modal-close waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
        <?php } // SI LA CONSULTA TRAE REGISTROS ?>
<?php
    }
require_once('footer.php');
?>