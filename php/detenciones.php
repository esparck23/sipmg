<?php
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_SESSION['detenido_id'])) {
            $_SESSION['detenido_id']=$_REQUEST['id'];
        }
    

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pg'])) {
            $pg = $_GET['pg'];
    
?>

        <div class="row row_principal">
            <!-- LISTADO DE DETENCIONES -->
            <div class="col s12 m10 offset-m1">
                <div class="card-panel">
                    <h6 class="class header_h2 center">Listado de Detenciones asociadas</h6><br>
                    <input type="hidden" name="detenido_id" id="detenido_id" value="<?= $id ?>">
                    <input type="hidden" name="pg" id="pg" value="<?= $pg ?>">

                    <div id="pagination_data_detenciones"> 
                        <!--SE CARGA UNA TABLA CON DETENCIONES DESDE JQUERY CON VALORES DE PHP PAGINADOS- -->  
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m6 offset-m1">
                            <?php if ($pg == "egreso") { ?> 
                                <a href="lista_egresos.php" title="Ir atrás" style="color:#fff" id="atras_egreso" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                            <?php } else { ?>
                                <a href="consulta.php" title="Ir atrás" style="color:#fff" id="atras_detencion" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                                <?php } ?>
                        </div>
                    </div>
                </div>   
            </div>
        </div>  
<?php
        }
    }
require_once('footer.php');
?> 