<?php
require_once('header.php');
include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];



        $sql = "SELECT * FROM delitos WHERE delito_id = $id";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();

?>
        <?php if (mysqli_num_rows( $result ) > 0) { ?>
        <div class="row row_principal">
            <div class="card-panel" id="editar_datos_delito_panel">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <h5>Editar Delito</h5></br>
                        <form method="POST" accept-charset="utf-8" action="delito_editado.php" id="formEditarDelito">
                            <div class="input-field col s6 m4">
                                <input type="hidden" name="codigo_delito_hidden" id="codigo_delito_hidden" value="<?= $row['codigo']; ?>">
                                <select id="codigo_delito" class="validate" name="codigo_delito" required="true">
                                    <option value="<?= $row['codigo']; ?>" disabled selected><?= $row['codigo']; ?></option>
                                </select>
                                <label for="codigo">Código*</label>
                                <span id="mensaje_delito" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            </div>
                            <div class="input-field col s6 m4">
                                <input id="nombre" name="nombre" value="<?= $row['nombre']; ?>" type="text" required="true" class="validate" filter="text">
                                <label for="nombre">Nombre*</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input id="descripcion" name="descripcion" value="<?= $row['descripcion']; ?>" type="text" required="true" class="validate" filter="text">
                                <label for="descripcion">Descripción*</label>
                            </div>
                            <div class="input-field col s6 m12">
                                <input type="hidden" name="id" value="<?= $row['delito_id']; ?>">
                                <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                <a href="delitos.php" id="atrasDelito" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                <button id="editarDelito" style="margin-left:30%" class="waves-effect waves-light btn green" type="button">Guardar cambios<i class="material-icons right">done</i></button>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php } // SI LA CONSULTA TRAE REGISTROS ?>
<?php
    }
require_once('footer.php');
?>
