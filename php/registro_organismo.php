<?php
    require_once('header.php');
?>
    <div class="row row_principal">
        <div class="card-panel" id="registro_datos_organismo_panel">
            <div class="row">
                <div class="col s12 m10 offset-m1">
                    <h5>Registrar Organismo</h5></br>
                    <form method="POST" accept-charset="utf-8" id="formRegistrOrganismo" action="registrar_organismo.php">
                        <div class="input-field col s12 m4">
                            <select id="codigo_organismo" class="validate" name="codigo_organismo" required="true">
                                <option value="0" disabled selected>Seleccione</option>
                            </select>
                            <label for="codigo_organismo">Código*</label>
                            <span id="mensaje_organismo" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="nombre" name="nombre" type="text" required="true" class="validate" filter="text">
                            <label for="nombre">Nombre del Organismo*</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="telefono" name="telefono" type="number" required="true" class="validate" filter="number" placeholder="02121234567">
                            <label for="telefono">Teléfono*</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <input id="descripcion" name="descripcion" type="text" required="true" class="validate" filter="text">
                            <label for="descripcion">Descripción*</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input id="correo" name="correo" type="email" required="true" class="validate" filter="email" placeholder="sipmg@ejemplo.com">
                            <label for="correo">Correo*</label>
                        </div>
                        <div class="input-field col s6 m4">
                                <select id="estado" class="validate" name="estado" required="true">
                                    <option value="0" disabled selected>Seleccione un estado</option>
                                </select>
                                <label for="estado">Estado*</label>
                            </div>
                            <div class="input-field col s6 m4">
                                <select id="municipio" class="validate" name="municipio" required="true">
                                <option value="0" disabled>Seleccione un municipio</option>
                                </select>
                                <label for="municipio">Municipio*</label>
                            </div>
                        <div class="input-field col s12 m12">
                            <input id="direccion" name="direccion" type="text" required="true" class="validate" filter="text">
                            <label for="direccion">Dirección*</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            <button id="registrarOrganismo" style="margin-left:40%" class="waves-effect waves-light btn" type="button">Registrar<i class="material-icons right">done</i></button>
                        </div> 
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require_once('footer.php');
?>
