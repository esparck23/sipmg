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
            <h6 class="class header_h2 center"><b>Listado de Egresados</b></h6>
            <?php if ($msj == '3') { ?>
                <span class="center"><p class="green" style="color:#fff">EDITADO EXITOSAMENTE.</p></span>
            <?php } else if ($msj == '2') { ?>
                <span class="center"><p class="red" style="color:#fff">HA OCURRIDO UN ERROR, POR FAVOR INTENTE NUEVAMENTE.</p></span>
            <?php } elseif ($msj == '1') { ?>
                <span class="center green"><p class="green">ELIMINADO EXITOSAMENTE.</p></span>
            <?php } ?>
            <div class="row"><br>
                <div class="col s6 m4 offset-m3">
                    <input class="input-field tooltipped validate" placeholder="EXP: 00000XXXX" data-position="bottom" data-tooltip="Buscar por Nro. De Expediente" require="require" type="text" id="query" name="query">
                </div>
                <div class="col s6 m4">
                    <button class="btn waves-effect waves-light red" id="buscarEgresadoBtn">Buscar</button>
                    <a style="display:none;" id="refrescar_consulta_egresados" href="#">Refrescar</a>
                </div>
            </div>
            <div id="listado_egresos"> <!--SE CARGA UNA TABLA DESDE JQUERY CON VALORES DE PHP PAGINADOS PAGINA: egresos_listado.php - TAMBIEN ES MODIFICADO SEGUN LA BUSQUEDA consulta_detenido_egreso.php -->  
            </div>
        </div> 

        <div class="card-panel">
            <h6 class="class header_h2 center"><b>Listado de Tipo de Egresos</b></h6>
            <button id="agregarTipoEgreso" data-target="modalRegistrarTipoEgreso" class="waves-effect waves-light btn tooltipped modal-trigger revocarAccesoPorPermisosDenegadosElemento" data-position="bottom" data-tooltip="Agregar Tipo de Egreso" type="button"><i class="material-icons">add</i></button>
            <?php if ($msj == '3') { ?>
                <span class="center"><p class="red" style="color:#fff">ERROR. EL TIPO DE EGRESO ESTÁ ASOCIADO A UN EGRESO ACTIVO.</p></span>
            <?php } elseif ($msj == '5') { ?>
                <span class="center green"><p class="green">ELIMINADO EXITOSAMENTE.</p></span>
            <?php } else { ?>

            <?php } ?>
            <div id="listado_tipoegreso"> <!--  SE CARGA UNA TABLA DESDE JQUERY CON VALORES DE PHP PAGINADOS PAGINA: tipoegreso_listado.php -  -->
            </div>
        </div>
    </div>
    <!-- MODAL-->
    <div id="modalRegistrarTipoEgreso" class="modal">
        <div class="modal-content">
            <h6 class="class header_h2 center"><b>Registrar Tipo de Egreso</b></h6>
            <div class="container">
                <div class="row">
                    <div class="input-field col s12 m12">
                        <form method="POST" accept-charset="utf-8" id="formRegistroTipoEgreso" action="registrar_tipoegreso.php">
                            <div class="input-field col s6 m6 offset-m1">
                                <input id="nombre" name="nombre" type="text" required="true" class="validate" filter="text">
                                <label for="nombre">Nombre*</label>
                            </div>
                            <div class="input-field col s6 m11 offset-m1">
                                <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                <button id="registrarTipoEgreso" class="waves-effect waves-light btn" type="button">Registrar</button>
                                <a href="javascript:void(0)" style="margin-left:30%" class="modal-close waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
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