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
            <h6 class="class header_h2 center"><b>Listado de Detenidos</b></h6>
            <?php if ($msj == '2') { ?>
                <span class="center"><p class="red" style="color:#fff">HA OCURRIDO UN ERROR, POR FAVOR INTENTE NUEVAMENTE.</p></span><br>
            <?php } elseif ($msj == '1') { ?>
            <span class="center green"><p class="green">REGISTRADO EXITOSAMENTE.</p></span><br>
            <?php } ?>
            <div class="row">
                <div class="col s6 m4 offset-m3">
                    <input class="input-field tooltipped validate" placeholder="Ingrese valor de búsqueda" data-position="bottom" data-tooltip="Buscar por Nro. De Expediente o Cédula" require="require" type="text" id="query" name="query">
                </div>
                <div class="col s6 m4">
                    <button class="btn waves-effect waves-light red" id="buscarActivoBtn">Buscar</button>
                    <a style="display:none;" id="refrescar_consulta" href="#">Refrescar</a>
                </div>
            </div>
            <div id="listado_datos_detenido">  <!--SE CARGA UNA TABLA DESDE JQUERY CON VALORES DE PHP PAGINADOS PAGINA: detenidos_listado.php - TAMBIEN ES AFECTADO SEGUN LA BUSQUEDA consulta_detenido.php -->  
            </div>
        </div>   
    </div>
</div>


<?php
require_once('footer.php');
?>                            