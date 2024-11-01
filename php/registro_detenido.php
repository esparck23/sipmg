<?php
    require_once('header.php');
    require_once 'conexion_db.php';
?> 
    <div class="row row_principal">
        <div class="col s12 m10 offset-m1">
            <div class="card-panel" id="registro_datos_detenidos_panel">
                
                        <div class="row">
                            <div class="col s6 m5 offset-m1">
                            <h5>Registrar Detenido</h5><br>
                            </div>
                            <div class="col s6 m5">
                                <button id="agregarDetenciones" class="btn red tooltipped revocarAccesoPorPermisosDenegadosElemento" data-position="bottom" data-tooltip="Opción para registrar múltiples Detenidos" type="button"><a style="color:#fff" href="registro_detenidos.php">Añadir Detenidos</button></a>
                            </div>
                        </div>
                    <div class="row">
                        
                    <div class="col s12 m10 offset-m1">
                        <form id="form_registro_datosf" action="backend.php" method="POST" accept-charset="utf-8" enctype="multipart/form-data">
                            <div class="row" id="registro_datosfiliatorios">
                                <div class="input-field col s6 m3">
                                    <select id="nacionalidad" class="validate" name="nacionalidad" required="true">
                                        <option value="0" disabled selected>nacionalidad *</option>
                                        <option value="1">V</option>
                                        <option value="2">E</option>
                                    </select>
                                </div>
                                <div class="input-field col s6 m4">
                                    <input id="cedula" name="cedula" type="number" required="true" class="validate" filter="number">
                                    <label for="cedula">Cédula de Identidad</label>
                                    <span id="mensaje_cedula" style="display:none" class="helper-text"></span>
                                    <input id="contador" style="display:none">
                                </div>
                                <div class="input-field col s6 m5">
                                    <input id="p_nombre" name="p_nombre" type="text" required="true" class="validate" filter="text">
                                    <label for="p_nombre">Primer nombre</label>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input  id="s_nombre" name="s_nombre" type="text" class="validate" class="validate" filter="text">
                                    <label for="s_nombre">Segundo nombre</label>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input id="p_apellido" name="p_apellido" type="text" class="validate" required="true" class="validate" filter="text">
                                    <label for="p_apellido">Primer apellido</label>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input id="s_apellido" name="s_apellido" type="text" class="validate" class="validate" filter="text">
                                    <label for="s_apellido">Segundo apellido</label>
                                </div>
                                <div class="input-field col s6 m6">
                                    <input id="fecha_nacimiento" type="text" name="fecha_n" class="validate" required="true">
                                    <label for="fecha_nacimiento">Fecha de nacimiento</label>
                                    <input id="tipo" type="hidden" value="registro_datosf" name="tipo">
                                    <input id="ultimo_id" type="hidden" value="" name="ultimo_id">
                                </div>
                                <div class="input-field col s6 m6">
                                    <label for="edad" class="label_edad">Edad calculada</label>
                                    <input id="edad_calculada" type="hidden" value="" name="edad_calculada">
                                    <input id="edad" class="edad_valor" type="number" name="edad" filter="number" disabled="disabled">
                                </div>
                                <div class="input-field col s6 m6">
                                    <select id="sexo" class="validate" name="sexo" required="true">
                                        <option value="0" disabled selected>Seleccione género*</option>
                                        <option value="1">M</option>
                                        <option value="2">F</option>
                                    </select>
                                    <label for="sexo">Sexo</label>
                                </div>
                                <div class="row col s12 m12">
                                    <p class="bold">Dirección</p>
                                    <div class="input-field col s6 m6">
                                        <select id="estado" class="validate" name="estado" required="true">
                                            <option value="0" disabled selected>Seleccione un Estado</option>
                                        </select>
                                        <label for="estado">Estado</label>
                                    </div>
                                    <div class="input-field col s6 m6">
                                        <select id="municipio" class="validate" name="municipio" required="true">
                                        <option value="0" disabled>Seleccione un Municipio</option>
                                        </select>
                                        <label for="municipio">Municipio</label>
                                    </div>
                                    <div class="input-field col s6 m12">
                                        <textarea id="direccion" name="direccion" class="materialize-textarea validate" required="true"></textarea>
                                        <label for="direccion">Dirección</label>
                                    </div>
                                </div>
                            </div>
                            <div class="file-field input-field">
                                <div class="btn btn-small red">
                                    <span>Cargar foto</span>
                                    <input type="file" class="validate" name="foto" id="foto" accept="image/*">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" id="campo_foto" type="text" placeholder="formatos: PNG, JPG, JPEG. Peso: 500Kb máximo">
                                    <div id="errores"></div>
                                </div>
                            </div><br>
                            <div class="input-field col s6 m12">
                                <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                <button data-target="modalRegistrarDatosf" id="registrarDatosf_btn" class="waves-effect waves-light btn modal-trigger" type="button" onclick="preguntarRegistroDatosf();">Registrar</button>
                            </div>

                            <!-- MODAL-->
                            <div id="modalRegistrarDatosf" class="modal">
                                <div class="modal-content">
                                    <h4 class="header_h2" style="text-align:center">Registro</h4>
                                    <p class="center red" style="color:#fff">El Detenido se registrará automáticamente despúes de su elección.</p>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col s12 m12">
                                                <p class="flow-text" style="text-align:center">¿Desea asociar una Detención?</p></br></br>
                                                <button type="button" class="btn waves-effect waves-light left btn-large" id="documentar_si">Si<i class="material-icons right">present_to_all</button></i>
                                                <button type="button" class="btn waves-effect red right btn-large" id="no_modal_registrar">No<i class="material-icons right">cancel_presentation</button></i>
                                            </div>
                                        </div>           
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<?php
require_once('footer.php');
?>  
                            