<?php
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

?>

        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                <div class="card-panel" id="registro_datos_detenidos_panel">
                    <div class="row">
                        <h5 class="center">ELIMINAR DETENIDO</h5></br>
                        <p class="center red" style="color:#fff">Recordar: La eliminación es una decisión de la Dirección General.</p>
                        <p class="center red" style="color:#fff">La eliminación implica la desaparición del Detenido en el sistema.</p>
                        <br>
                        <div class="col s12 m4 offset-m2">
                        <input type="hidden" name="detenido_id" id="detenido_id" value="<?= $id; ?>">
                        <a href="consulta.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                        </div>
                        <div class="col s12 m4 offset-m2">
                        <a href="javascript:void(0)" style="color:#fff" title="Eliminar" id="btnEliminarDetenido" class="waves-effect waves-light btn red">ELIMINAR<i class="material-icons right">delete</i></a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

<?php
    }
require_once('footer.php');
?>
