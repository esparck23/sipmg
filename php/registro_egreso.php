<?php
    require_once('header.php');
    require_once 'conexion_db.php';
?> 
    <div class="row row_principal">
        <div class="col s12 m10 offset-m1">
            <div class="card-panel" id="registro_datos_detenidos_panel">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <div id="documentar_ingreso_datosf">
                            <form id="form_registrar_egreso" action="backend_egreso.php" method="POST" accept-charset="utf-8">
                                <div class="row">
                                    <div class="col s12 m12">
                                        <h5>Registrar Egreso</h5></br>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <input id="fecha_egreso" type="text" class="validate" name="fecha_egreso" required="true" filter="text">
                                        <label for="fecha_egreso">Fecha Egreso</label>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <select name="tipo_egreso"  id="tipo_egreso" required="true" class="validate">
                                            <option value="0" selected disabled>Tipo de Egreso *</option>
                                            <?php
                                            $query = "SELECT * FROM tipo_egresos";
                                            $res = $conexion->query($query);

                                            while ($valores = mysqli_fetch_array($res)) {
                                                echo '<option value="'.$valores["tipoegreso_id"].'">'.$valores["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <textarea id="descripcion_egreso" class="materialize-textarea validate" name="descripcion_egreso" required="true"></textarea>
                                        <label for="descripcion_egreso">Descripción</label>
                                    </div>
                                        <div class="input-field col s6 m12">
                                            <p class="bold red">Selecciona la Detención y Detenido que corresponde al egreso</p><br>
                                            <select name="detencion_detenido" id="detencion_detenido" required="true" class="validate">
                                                <option value ="0" selected disabled>Seleccione una opción*</option>
                                                <?php
                                                $query = "SELECT detenciones.numero,
                                                                 detenciones.detencion_id,
                                                                 detalle_detenidos.primer_nombre,
                                                                 detalle_detenidos.primer_apellido,
                                                                 detenidos.ciudadano_idfk,
                                                                 detenidos.cedula
                                                    FROM detenidos, detenciones, detalle_detenidos, detalle_detenciones
                                                    WHERE detenidos.detenido_id = detalle_detenidos.detenido_idfk
                                                    AND detenciones.detenido_idfk = detenidos.detenido_id
                                                    AND detalle_detenciones.detencion_idfk = detenciones.detencion_id
                                                    AND detenciones.estatus = 'DETENIDO'
                                                    AND detenciones.oculto = 0
                                                    ORDER BY detenidos.detenido_id DESC";
                                                $res = $conexion->query($query);

                                                while ($valores = mysqli_fetch_array($res)) {
                                                    echo '<option value="'.$valores["detencion_id"].'">Expediente: Nro. '.$valores["numero"].' | Datos del detenido: '.$valores["primer_nombre"].' '.$valores["primer_apellido"] .' '. $nac = ($valores["ciudadano_idfk"]== "1") ? "V-".$valores["cedula"] : "E-".$valores["cedula"].'</option>';
                                                }
                                                ?>
                                            </select>
                                            <input id="tipo" type="hidden" style="display:none" value="registro_egreso" name="tipo">
                                        </div>
                                    <div class="input-field col s6 m12">
                                        <span id="mensaje_campos_egreso" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                        
                                        <button type="button" style="margin-left:37%" class="waves-effect waves-light btn" id="btnEnviarEgreso">Registrar<i class="material-icons right">done</i></button>
                                    </div>
                                </div>
                            </form>
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
    </div>
<?php
require_once('footer.php');
?>  
                            