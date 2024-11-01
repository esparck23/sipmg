<?php
require_once('header.php');
?>
    <div class="row row_principal">
        <div class="card-panel" id="registro_datos_delito_panel">
            <div class="row">
                <div class="col s12 m10 offset-m1">
                    <h5>Registrar Delito</h5></br>
                    <form method="POST" accept-charset="utf-8" id="formRegistroDelito" action="registrar_delito.php">
                        <div class="input-field col s6 m4">
                            <select id="codigo_delito" class="validate" name="codigo_delito" required="true">
                                <option value="0" disabled selected>Seleccione</option>
                            </select>
                            <label for="codigo">Código*</label>
                            <span id="mensaje_delito" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                        </div>
                        <div class="input-field col s6 m4">
                            <input id="nombre" name="nombre" type="text" required="true" class="validate" filter="text">
                            <label for="nombre">Nombre*</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <input id="descripcion" name="descripcion" type="text" required="true" class="validate" filter="text">
                            <label for="descripcion">Descripción*</label>
                        </div>
                        <div class="input-field col s12 m12">
                            <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            <button id="registrarDelito" style="margin-left:35%" class="waves-effect waves-light btn" type="button">Registrar<i class="material-icons right">done</i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require_once('footer.php');
?>
