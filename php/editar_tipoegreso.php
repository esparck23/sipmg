<?php
require_once('header.php');
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tipo_egresos WHERE tipoegreso_id = $id";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
}
?>
    <div class="row row_principal">
        <div class="card-panel" id="editar_datos_tipoegreso_panel">
            <div class="row">
                <div class="col s12 m10 offset-m1">
                    <h5>Editar Tipo de Egreso</h5></br>
                    <form method="POST" accept-charset="utf-8" action="tipoegreso_editado.php" id="formEditarTipoEgreso">
                        <div class="input-field col s6 m4">
                            <input id="nombre" name="nombre" value="<?= $row['nombre']; ?>" type="text" required="true" class="validate" filter="text">
                            <label for="nombre">Nombre*</label>
                        </div>
                        <div class="input-field col s6 m12">
                            <input type="hidden" name="id" value="<?= $row['tipoegreso_id']; ?>">
                            <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            <button id="editarTipoEgreso" class="waves-effect waves-light btn green" type="button">Guardar cambios<i class="material-icons right">done</i></button>
                            
                            <a href="lista_egresos.php" id="atrasTipoEgreso" style="margin-left:30%" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
require_once('footer.php');
?>
