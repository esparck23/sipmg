<?php
    require_once('header.php');
    require_once 'conexion_db.php';


    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Consulta SQL para obtener los datos
            $sql = "SELECT  detenciones.*,
            detalle_detenciones.*,
                    direcciones.*,
                    delitos.nombre AS nombre_delito,
                    organismos.nombre AS nombre_organismo,
                    detenidos.*,
                    detalle_detenidos.*
            FROM  detenciones
            LEFT JOIN  detalle_detenciones ON  detalle_detenciones.detencion_idfk  =  detenciones.detencion_id
            LEFT JOIN  delitos ON  delitos.delito_id  =  detenciones.delito_idfk
            LEFT JOIN  organismos ON  organismos.organismo_id  =  detenciones.organismo_idfk
            LEFT JOIN  detenidos ON  detenidos.detenido_id  =  detenciones.detenido_idfk 
            LEFT JOIN  detalle_detenidos ON  detalle_detenidos.detenido_idfk  =  detenidos.detenido_id
            LEFT JOIN  direcciones ON  detalle_detenciones.direccion_idfk  =  direcciones.direccion_id
            WHERE detenciones.detencion_id = '$id'";
            $resultado = $conexion->query($sql);
            $row = $resultado->fetch_assoc();
    


?> 
        <?php if (mysqli_num_rows( $resultado ) > 0) { ?>
        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                <div class="card-panel" id="registro_datos_detencion_panel">
                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <div id="documentar_ingreso_datosf">
                                <form id="formEditarDetencion" enctype="multipart/form-data" action="detencion_editado.php" method="POST" accept-charset="utf-8">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <h5>Editar Detención</h5></br>
                                        </div>
                                        <div class="input-field col s6 m6">
                                            <input id="expediente" type="text" disabled="disabled" class="disabled" value="<?= $row['numero']; ?>" name="expediente">
                                            <label for="expediente">Nro. Expediente</label>
                                        </div>
                                        <div class="input-field col s6 m6">
                                            <input id="f_ingreso" type="text" class="validate" value="<?= $row['fecha_ingreso']; ?>" name="f_ingreso" required="true" filter="text">
                                            <label for="f_ingreso">Fecha de ingreso</label>
                                        </div>
                                        <div class="input-field col s12 m12">
                                            <input id="lugar_detencion" type="text" class="validate" value="<?= $row['lugar']; ?>" name="lugar_detencion" required="true" filter="text">
                                            <label for="lugar_detencion">Lugar de detención</label>
                                        </div>
                                        <div class="input-field col s12 m12">
                                            <textarea id="descripcion_detencion" class="materialize-textarea validate"  name="descripcion_detencion" required="true"><?= $row['descripcion']; ?></textarea>
                                            <label for="descripcion_detencion">Descripción</label>
                                        </div>
                                        <div class="input-field col s6 m6">
                                            <input id="delito_hidden" type="hidden" style="display:none" value="<?= $row['delito_idfk']; ?>" name="delito_hidden">
                                            <select name="delito"  id="delito" required="true" class="validate">
                                                <option value="<?= $row['delito_idfk']; ?>" selected disabled><?= $row['nombre_delito']; ?></option>
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
                                            <input id="organismo_hidden" type="hidden" style="display:none" value="<?= $row['organismo_idfk']; ?>" name="organismo_hidden">
                                            <select name="organismo" id="organismo" required="true" class="validate">
                                                <option value="<?= $row['organismo_idfk']; ?>" selected disabled><?= $row['nombre_organismo']; ?></option>
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
                                        <div class="input-field col s6 m12">
                                            <p class="bold red"><b>DETENCION ASOCIADA A DETENIDO. PARA CAMBIAR LA VINCULACION SELECCIONE OTRO DETENIDO DE LA LISTA CON PREVIA AUTORIZACION</b></p><br>
                                            <input id="detenido_hidden" type="hidden" style="display:none" value="<?= $row['detenido_idfk']; ?>" name="detenido_hidden">
                                            <select name="detenido" id="detenido" required="true" class="validate">
                                                <option value ="<?= $row['detenido_idfk']; ?>" selected disabled>Nombre completo: <?= $row['primer_nombre'].' '.$row['primer_apellido']; ?> | Identificación: <?= $nac = ($row["ciudadano_idfk"]== "1") ? "V-".$row["cedula"] : "E-".$row["cedula"]; ?></option>
                                                <?php
                                                $query = "SELECT * FROM detenidos, detalle_detenidos WHERE detenidos.detenido_id = detalle_detenidos.detenido_idfk AND detenidos.oculto = 0";
                                                $res = $conexion->query($query);

                                                while ($valores = mysqli_fetch_array($res)) {
                                                    echo '<option value="'.$valores["detenido_id"].'">Nombre completo: '.$valores["primer_nombre"].' '.$valores["primer_apellido"] .' | Identificación: '. $nac = ($valores["ciudadano_idfk"]== "1") ? "V-".$valores["cedula"] : "E-".$valores["cedula"].'</option>';
                                                }
                                                ?>
                                            </select>
                                            <label for="detenido">Detenido</label>
                                            <input id="tipo" type="hidden" style="display:none" value="registro_detencion_porlista" name="tipo">
                                        </div>

                                        <div class="row col s12 m12">
                                            <p class="bold"><b>Dirección</b></p>
                                            <div class="input-field col s6 m6">
                                                <input type="hidden" name="estado_hidden" id="estado_hidden" value="<?php echo $row['estado']; ?>">
                                                
                                                <select id="estado" class="validate" name="estado" required="true">
                                                    <option value="<?= $row['estado']; ?>" disabled selected><?= $row['estado']; ?></option>
                                                </select>
                                                <label for="estado">Estado</label>
                                            </div>
                                            <div class="input-field col s6 m6">
                                                <input type="hidden" name="municipio_hidden" id="municipio_hidden" value="<?php echo $row['municipio']; ?>">
                                                
                                                <select id="municipio" class="validate" name="municipio" required="true">
                                                <option value="<?= $row['municipio']; ?>" disabled selected><?= $row['municipio']; ?></option>
                                                </select>
                                                <label for="municipio">Municipio</label>
                                            </div>
                                            <div class="input-field col s6 m12">
                                                <input type="hidden" name="direccion_id" id="direccion_id" value="<?= $row['direccion_idfk'] ?>">
                                                <textarea id="direccion_detencion" name="direccion_detencion" class="materialize-textarea validate" required="true"><?= $row['direccion']; ?></textarea>
                                                <label for="direccion_detencion">Dirección</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s12 m12">
                                            <input type="hidden" name="id" id="detencion_id" value="<?= $id ?>">
                                            <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                            <a href="lista_detenciones.php" id="atrasDetencion" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                            <button id="editarDetencion" class="waves-effect waves-light btn green"  style="margin-left: 40%;"  type="button">Guardar cambios<i class="material-icons right">done</i></button>
                                        </div>
                                    </div>
                                </form>
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
                            