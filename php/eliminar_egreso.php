<?php
require_once('header.php');
include 'conexion_db.php';

    $detencion_id = "";
    if(isset($_SESSION['detencion_id'])){
        // traído desde detenciones.php
        $detencion_id = $_SESSION['detencion_id'];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
?>
        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                <div class="card-panel" id="registro_datos_detenidos_panel">
                    <div class="row">
                        <h5 class="center">Eliminar Egreso</h5></br>
                        <p class="center red" style="color:#fff">Recordar: La eliminación es una decisión de la Dirección General.</p>
                        <p class="center red" style="color:#fff">La eliminación implica deshacer el Egreso</p>
                        <br>
                        <div class="col s12 m4 offset-m2">
                            <a href="lista_egresos.php" style="color:#fff" title="Ir atrás" id="irAtrasEgreso" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                        </div>
                        <div class="col s12 m4 offset-m2">
                            <input type="hidden" name="detencion_id" id="detencion_id" value="<?= $id; ?>">
                            <a href="javascript:void(0)" style="color:#fff" title="Eliminar" id="btnEliminarEgreso" style="margin-right:40%;"  class="waves-effect waves-light btn red">ELIMINAR<i class="material-icons right">delete</i></a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

<?php
    }
require_once('footer.php');
?>
