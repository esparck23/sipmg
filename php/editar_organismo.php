<?php
    ob_start();
    require_once('header.php');
    include 'conexion_db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM organismos, direcciones WHERE organismo_id = $id AND organismos.direccion_idfk = direcciones.direccion_id";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();
    
    ob_end_flush();
?>
        <?php if (mysqli_num_rows( $result ) > 0) { ?>
        <div class="row row_principal">
            <div class="card-panel" id="registro_datos_organismo_panel">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <h5>Editar Organismo</h5></br>
                        <form method="POST" accept-charset="utf-8" action="organismo_editado.php" id="formEditarOrganismo">
                            <div class="input-field col s12 m4">
                                <input type="hidden" name="codigo_organismo_hidden" id="codigo_organismo_hidden" value="<?= $row['codigo']; ?>">
                                <select id="codigo_organismo" class="validate" name="codigo_organismo" required="true">
                                    <option value="<?= $row['codigo']; ?>" disabled selected><?= $row['codigo']; ?></option>
                                </select>
                                <label for="codigo_organismo">Código*</label>
                                <span id="mensaje_organismo" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            </div>
                            <div class="input-field col s12 m4">
                                <input id="nombre" name="nombre" type="text" required="true" value="<?= $row['nombre']; ?>" class="validate" filter="text">
                                <label for="nombre">Nombre del Organismo*</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input id="telefono" name="telefono" type="number" value="<?= $row['telefono']; ?>" required="true" class="validate" filter="number" placeholder="02121234567">
                                <label for="telefono">Teléfono*</label>
                            </div>
                            <div class="input-field col s12 m12">
                                <input id="descripcion" name="descripcion" type="text" value="<?= $row['descripcion']; ?>" required="true" class="validate" filter="text">
                                <label for="descripcion">Descripción*</label>
                            </div>
                            <div class="input-field col s12 m4">
                                <input id="correo" name="correo" type="email" required="true" value="<?= $row['correo']; ?>" class="validate" filter="email" placeholder="sipmg@ejemplo.com">
                                <label for="correo">Correo*</label>
                            </div>
                            <div class="input-field col s6 m4">
                                    <select id="estado" class="validate" name="estado" required="true">
                                        <option value="<?= $row['estado']; ?>" disabled selected><?= $row['estado']; ?></option>
                                    </select>
                                </div>
                                <div class="input-field col s6 m4">
                                    <select id="municipio" class="validate" name="municipio" required="true">
                                    <option value="<?= $row['municipio']; ?>" disabled selected><?= $row['municipio']; ?></option>
                                    </select>
                                </div>
                            <div class="input-field col s12 m12">
                                <input id="direccion" name="direccion" type="text" required="true" value="<?= $row['direccion']; ?>" class="validate" filter="text">
                                <label for="direccion">Dirección*</label>
                            </div>
                            <div class="input-field col s6 m12">
                                <input type="hidden" name="id" value="<?= $row['organismo_id']; ?>">
                                <input type="hidden" name="direccion_id" value="<?= $row['direccion_id']; ?>">
                                <input type="hidden" name="estado_hidden" id="estado_hidden" value="<?= $row['estado']; ?>">
                                <input type="hidden" name="municipio_hidden" id= "municipio_hidden" value="<?= $row['municipio']; ?>">
                                <span id="mensaje_campos" style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                                <a href="organismos.php" id="atrasOrganismo" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                <button id="editarOrganismo" style="margin-left:30%" class="waves-effect waves-light btn green" type="button">Guardar cambios<i class="material-icons right">done</i></button>
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
