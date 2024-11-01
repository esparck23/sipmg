<?php
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Consulta SQL para obtener los datos
        $sql = "SELECT *, organismos.nombre AS organismo, delitos.nombre AS delito, tipo_egresos.nombre AS tipo_egreso, egreso_detenciones.egreso_id, egreso_detenciones.descripcion AS descripcion_egreso
        FROM detenciones, egreso_detenciones, detalle_detenciones, organismos, delitos, direcciones, tipo_egresos
        WHERE egreso_detenciones.detencion_idfk = detenciones.detencion_id
        AND detalle_detenciones.detencion_idfk = detenciones.detencion_id
        AND direcciones.direccion_id = detalle_detenciones.direccion_idfk
        AND organismos.organismo_id = detenciones.organismo_idfk
        AND delitos.delito_id = detenciones.delito_idfk
        AND egreso_detenciones.tipoegreso_idfk = tipo_egresos.tipoegreso_id
        AND egreso_detenciones.detencion_idfk = '$id' ORDER BY egreso_detenciones.detencion_idfk DESC";
        $resultado = $conexion->query($sql);
        $row = $resultado->fetch_assoc();
    

?> 
        <?php if (mysqli_num_rows( $resultado ) > 0) { ?>
        <div class="row row_principal">
        <div class="col s12 m10 offset-m1">
            <div class="card-panel" id="registro_datos_detencion_panel">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <form id="formEditarEgreso" enctype="multipart/form-data" action="egreso_editado.php" method="POST" accept-charset="utf-8">
                            <div class="row">
                                <div class="col s12 m12">
                                    <h5>Editar Egreso</h5></br>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input id="fecha_egreso" type="text" class="validate" value="<?= $row['fecha_egreso']; ?>" name="fecha_egreso" required="true" filter="text">
                                    <label for="fecha_egreso">Fecha de Egreso</label>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input id="tipoegreso_hidden" type="hidden" style="display:none" value="<?= $row['tipoegreso_idfk']; ?>" name="tipoegreso_hidden">
                                    <select name="tipo_egreso"  id="tipo_egreso" required="true" class="validate">
                                        <option value="<?= $row['tipoegreso_idfk']; ?>" selected disabled><?= $row['tipo_egreso']; ?></option>
                                        <?php
                                        $query = "SELECT * FROM tipo_egresos";
                                        $res = $conexion->query($query);

                                        while ($valores = mysqli_fetch_array($res)) {
                                            echo '<option value="'.$valores["tipoegreso_id"].'">'.$valores["nombre"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="nombre_tipo_egreso">Tipo de Egreso</label>
                                </div>
                                <div class="input-field col s6 m12">
                                    <textarea id="descripcion_egreso" class="validate materialize-textarea" name="descripcion_egreso" required="true" filter="text"><?= $row['descripcion_egreso']; ?></textarea>
                                    <label for="descripcion_egreso">Descripción del Egreso</label>
                                </div>
                                <div class="input-field col s4 m10 offset-m1">
                                    <p class="center red"><b><i>¡IMPORTANTE!</i> A continuación se muestra la Detención Asociada, si desea cambiarla debe ser bajo aprobación por la Dirección General.</b></p><br>
                                </div>
                                <div class="input-field col s6 m12">
                                    <input id="detencion_hidden" type="hidden" style="display:none" value="<?= $row['detencion_idfk']; ?>" name="detencion_hidden">
                                    <select name="detencion" id="detencion" required="true" class="validate">
                                        <option value ="<?= $row['detencion_idfk']; ?>" selected disabled>Expediente: <?= $row['numero']?> | Fecha de Ingreso: <?= $row['fecha_ingreso'] ?></option>
                                        <?php
                                        $query = "SELECT * FROM detenciones, detalle_detenciones WHERE detenciones.detencion_id = detalle_detenciones.detencion_idfk AND detenciones.estatus = 'DETENIDO' AND detenciones.oculto = 0 GROUP BY detenciones.detencion_id ORDER BY detenciones.detencion_id DESC";
                                        $res = $conexion->query($query);

                                        while ($valores = mysqli_fetch_array($res)) {
                                            echo '<option value="'.$valores["detencion_id"].'">Expediente: '.$valores["numero"].' | Fecha de Ingreso: '. $valores["fecha_ingreso"].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <label for="descripcion_egreso">Detenciones activas</label>
                                    <input id="tipo" type="hidden" style="display:none" value="editar_egreso" name="tipo">
                                    
                                </div>
                                <div class="input-field col s12 m11">
                                    <input type="hidden" name="egreso_id" id="egreso_id" value="<?= $row['egreso_id'] ?>">
                                    <span id="mensaje_campos"style="color:red"  class="helper-text" data-error="wrong" data-success="right"></span>
                                    <a href="lista_egresos.php" id="atrasEgreso"  class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                    <button id="editarEgreso" style="margin-left: 40%;" class="waves-effect waves-light btn green" type="button">Guardar cambios<i class="material-icons right">done</i></button>
                                </div>
                            </div>
                        </form>
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