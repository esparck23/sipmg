<?php
require_once('header.php');
include 'conexion_db.php';

$msj = "";
if (isset($_GET["msj"]) && $_GET["msj"] > 0) {
   $msj = $_GET["msj"];
}
?>

    <div class="row row_principal">
        <!-- DETENIDOS GENERAL -->
        <div class="col s12 m10 offset-m1">
            <div class="card-panel">
                <h6 class="class header_h2 center"><b>Listado de Delitos</b></h6>
                <?php if ($msj == '2') { ?>
                    <span class="center"><p class="red" style="color:#fff">No se pudo eliminar. El Delito está vinculado a una Detención Activa.</p></span>
                <?php } elseif ($msj == '1') { ?>
                    <span class="center green"><p class="green">Eliminado Exitosamente.</p></span>
                <?php } else { ?>

                <?php } ?>
                <div id="listado_delitos"> <!--  SE CARGA UNA TABLA DESDE JQUERY CON VALORES DE PHP PAGINADOS PAGINA: delitos_listado.php -  -->
                </div>
            </div>   
        </div>
    </div>

<?php
require_once('footer.php');
?>

