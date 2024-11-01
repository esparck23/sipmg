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
                            <form id="form_doc_interno_detenido" enctype="multipart/form-data"  <?= $retVal = (isset($_GET['id']) && $_GET['id'] > 0) ? 'action="backend_detencion.php?id='.$_GET['id'].'"' : 'action="backend_detencion.php"';?> method="POST" accept-charset="utf-8">
                                <div class="row">
                                    <?php if (!isset($_GET['id'])) { ?>
                                    <div class="col s6 m6">
                                        <h5>Registrar Detención</h5></br>
                                    </div>
                                    <?php } else{ ?>
                                    <div class="col s12 m12">
                                        <h5>Registrar Detención</h5></br>
                                    </div>
                                    <?php } ?>
                                    <?php if (!isset($_GET['id'])) { ?>
                                    <div class="col s6 m6">
                                        <button id="agregarDetenciones" class="btn red tooltipped" data-position="bottom" data-tooltip="Opción para registrar múltiples detenciones" type="button"><a style="color:#fff" href="registro_detenciones.php">Añadir Detenciones</button></a>
                                    </div>
                                    <div class="col s12 m12"></br>
                                    </div>
                                    <?php } ?>
                                    <div class="input-field col s6 m6">
                                        <input id="expediente" type="text" class="validate" name="expediente" required="true" filter="text">
                                        <label for="expediente">Nro. Expediente</label>
                                        <span id="mensaje_expediente" style="display:none" class="helper-text"></span>
                                        <input id="contador_expediente" style="display:none">
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <input id="f_ingreso" type="text" class="validate" name="f_ingreso" required="true" filter="text">
                                        <label for="f_ingreso">Fecha de ingreso</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <input id="lugar_detencion" type="text" class="validate" name="lugar_detencion" required="true" filter="text">
                                        <label for="lugar_detencion">Lugar de detención</label>
                                    </div>
                                    <div class="input-field col s12 m12">
                                        <textarea id="descripcion_detencion" class="materialize-textarea validate" name="descripcion_detencion" required="true"></textarea>
                                        <label for="descripcion_detencion">Descripción</label>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <select name="delito"  id="delito" required="true" class="validate">
                                            <option value="0" selected disabled>Delito*</option>
                                            <?php
                                            $query = "SELECT * FROM delitos";
                                            $res = $conexion->query($query);

                                            while ($valores = mysqli_fetch_array($res)) {
                                                echo '<option value="'.$valores["delito_id"].'">'.$valores["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="delito">Delito</label>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <select name="organismo" id="organismo" required="true" class="validate">
                                            <option value="0" selected disabled>Organismo*</option>
                                            <?php
                                            $query = "SELECT * FROM organismos";
                                            $res = $conexion->query($query);

                                            while ($valores = mysqli_fetch_array($res)) {
                                                echo '<option value="'.$valores["organismo_id"].'">'.$valores["nombre"].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <label for="organismo">Organismo</label>
                                    </div>
                                    <?php if (!isset($_GET['id'])) { ?>

                                    <div class="input-field col s6 m12">
                                        <p class="bold red" style="color:white;">Seleccione un Detenido existente para el registro de la Deteción</p><br>
                                        <select name="detenido" id="detenido" required="true" class="validate">
                                            <option value ="0" selected disabled>Seleccione un detenido*</option>
                                            <?php
                                                $query = "SELECT d.*, dd.*
                                                FROM detenidos d
                                                JOIN detalle_detenidos dd ON d.detenido_id = dd.detenido_idfk
                                                WHERE d.oculto = 0
                                                AND NOT EXISTS (
                                                    SELECT 1
                                                    FROM detenciones det
                                                    WHERE det.detenido_idfk = d.detenido_id
                                                    AND det.estatus = 'DETENIDO'
                                                )";
                                                $res = $conexion->query($query);

                                                while ($valores = mysqli_fetch_array($res)) {
                                                    echo '<option value="'.$valores["detenido_id"].'">Nombre completo: '.$valores["primer_nombre"].' '.$valores["primer_apellido"] .' | Identificación: '. $nac = ($valores["ciudadano_idfk"]== "1") ? "V-".$valores["cedula"] : "E-".$valores["cedula"].'</option>';
                                                }
                                            ?>
                                        </select>
                                        <label for="detenido">Detenido</label>
                                    </div>
                                    <?php } ?>
                                    <div class="row col s12 m12">
                                        <input id="tipo" type="hidden" style="display:none" <?= $retVal = (!isset($_GET['id'])) ? 'value="registro_detencion_porlista"' : 'value="registro_detencion"' ; ?> name="tipo">
                                        <p class="bold">Dirección</p></b>
                                        <div class="input-field col s6 m6">
                                            <select id="estado" class="validate" name="estado" required="true">
                                                <option value="0" disabled selected>Seleccione un Estado*</option>
                                            </select>
                                            <label for="estado">Estado</label>
                                        </div>
                                        <div class="input-field col s6 m6">
                                            <select id="municipio" class="validate" name="municipio" required="true">
                                            <option value="0" disabled>Seleccione un Municipio</option>
                                            </select>
                                            <label for="municipio">Municipio</label>
                                        </div>
                                        <div class="input-field col s6 m12">
                                            <textarea id="direccion_detencion" name="direccion_detencion" class="materialize-textarea validate" required="true"></textarea>
                                            <label for="direccion_detencion">Dirección</label>
                                        </div>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <span id="mensaje_campos_in_detenido" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                        
                                        
                                        <?php if (!isset($_GET['id'])) { ?> <button type="button" class="waves-effect waves-light btn" id="btnEnviarPorLista">Registrar</button><?php } else { ?><button type="button" class="red btn-small left" id="cancelar">Cancelar</button><button type="button" class="btn waves-effect green btn-small right" id="btnEnviar">Registrar</button><?php } ?>
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
                            