<?php
    // ##################### REGISTRO DE MULTIPLES DETENIDOS #####################
    // ##################### REGISTRO DE MULTIPLES DETENIDOS #####################
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
                        <h5 class="center">Registrar Detenidos</h5></br>
                        <?php if ($msj == '2') { ?>
                            <span class="center"><p class="red" style="color:#fff">HA OCURRIDO UN ERROR, POR FAVOR INTENTE NUEVAMENTE.</p></span><br>
                        <?php } elseif ($msj == '1') { ?>
                            <span class="center green"><p class="green">REGISTRADO EXITOSAMENTE.</p></span><br>
                        <?php } ?>
                        <div class="card-panel">
                            <div class="row">
                                <div class="col s12 m12">
                                    <div class="input-field col s6 m6">
                                        <input type="number" id="numero_bloques_detenidos" name="numero_bloques_detenidos" max="10" placeholder="1-10" required="true" class="validate">
                                        <span for="numero_bloques"><b>Ingrese el número de bloques</b></span><br>
                                    </div>
                                    <div class="col s6 m6">
                                        <button id="nuevoBloqueCamposDetenido" class="btn green tooltipped" data-position="button" data-tooltip="Crear los bloques de campos" type="button"><i class="material-icons">grid_view</i> <i class="material-icons">check</i></button>
                                        <button id="eliminar_ultimobloqueDetenido_btn" class="btn black tooltipped center" data-position="right" data-tooltip="Eliminar un bloque" type="button"><i class="material-icons">backspace</i></button>
                                        <button id="borrar_bloquesDetenido_btn" class="btn red tooltipped right" data-position="left" data-tooltip="Borrar todos los bloques" type="button"><i class="material-icons">delete</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m12">
                            <form id="formularioDinamicoDetenidos" action="registrar_detenidos.php" method="POST" enctype="multipart/form-data">
                                <div id="ContenedorBloquesDetenidos">
                                </div>
                                <div id="botoneraBloquesDetenidos">
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <div class="col s12 m12">
                                <a href="registro_detenido.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue center">ATRAS<i class="material-icons right">arrow_back</i></a>
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