<?php
    // ##################### REGISTRO DE MULTIPLES DETENCIONES #####################
    // ##################### REGISTRO DE MULTIPLES DETENCIONES #####################
    require_once('header.php');
    require_once 'conexion_db.php';

    $msj = "";
    if (isset($_GET["msj"]) && $_GET["msj"] > 0) {
        $msj = $_GET["msj"];
    }
?> 
    <div class="row row_principal">
        <div class="col s12 m10 offset-m1">
            <div class="card-panel" id="registro_datos_detenidos_panel">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <h5 class="center">Registrar Detenciones</h5></br>
                        <?php if ($msj == '4') { ?>
                            <span class="center"><p class="red" style="color:#fff">ERROR. HA SELECCIONADO UN MISMO DETENIDO PARA MAS DE UNA DETENCION, POR FAVOR INTENTE NUEVAMENTE.</p></span><br>
                        <?php } elseif ($msj == '1') { ?>
                            <span class="center green"><p class="green">REGISTRADO EXITOSAMENTE.</p></span><br>
                        <?php } ?>
                        <div class="card-panel">
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="input-field col s6 m6">
                                        <input type="number" id="numero_bloques" name="numero_bloques" max="10" placeholder="1-10" required="true" class="validate">
                                        <span for="numero_bloques"><b>Ingrese el número de bloques</b></span><br>
                                    </div>
                                    <div class="col s6 m6">
                                        <button id="nuevoBloqueCampos" class="btn green tooltipped" data-position="button" data-tooltip="Crear los bloques de campos" type="button"><i class="material-icons">grid_view</i> <i class="material-icons">check</i></button>
                                        <button id="eliminar_ultimobloque_btn" class="btn black tooltipped center" data-position="bottom" data-tooltip="Eliminar un bloque" type="button"><i class="material-icons">backspace</i></button>
                                        <button id="borrar_bloques_btn" class="btn red tooltipped right" data-position="bottom" data-tooltip="Borrar todos los bloques" type="button"><i class="material-icons">delete</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m12">
                            <form id="formularioDinamicoDetenciones" action="registrar_detenciones.php" method="POST" enctype="multipart/form-data">
                                <div id="ContenedorBloques">
                                </div>
                                <div id="botoneraBloques">
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col s12 m12">
                                <a href="registro_detencion.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue center">ATRAS<i class="material-icons right">arrow_back</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<?php
require_once('footer.php');
?>  
                            