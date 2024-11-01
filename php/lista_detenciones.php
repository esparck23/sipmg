<?php
require_once('header.php');
include 'conexion_db.php';
?>


<div class="row row_principal">
    <!-- DETENIDOS GENERAL -->
    <div class="col s12 m10 offset-m1">
        <div class="card-panel">
            <h6 class="class header_h2 center"><b>Listado de Detenciones</b></h6>
            <div class="row">
                <div class="col s6 m4 offset-m3">
                    <input class="input-field tooltipped validate" placeholder="Ingrese valor de búsqueda" data-position="bottom" data-tooltip="Buscar por Nro. De Expediente" require="require" type="text" id="query" name="query">
                </div>
                <div class="col s6 m4">
                    <button class="btn waves-effect waves-light red" id="buscarDetencionBtn">Buscar</button>
                    <a style="display:none;" id="refrescar_consulta_detencion" href="#">Refrescar</a>
                </div>
            </div>
            <div id="listado_detenciones">
                <!--SE CARGA UNA TABLA DESDE JQUERY CON VALORES DE PHP PAGINADOS PAGINA: detenciones_listado.php y consulta_lista_detencion.php -->  
            </div>
        </div> 
    </div>
</div>

<?php
require_once('footer.php');
?>                            