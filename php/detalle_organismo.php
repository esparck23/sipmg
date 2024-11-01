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
                                    <span class="helper-text"><b>Código</b></span>
                                    <p><?= $row["codigo"];?></p>
                                </div>
                                <div class="input-field col s12 m4">
                                    <span class="helper-text"><b>Nombre del Organismo</b></span>
                                    <p><?= $row["nombre"];?></p>
                                </div>
                                <div class="input-field col s12 m4">
                                    <span class="helper-text"><b>Teléfono</b></span>
                                    <p><?= $row["telefono"];?></p>
                                </div>
                                <div class="input-field col s12 m12">
                                    <span class="helper-text"><b>Descripción</b></span>
                                    <p><?= $row["descripcion"];?></p>
                                </div>
                                <div class="input-field col s12 m4">
                                    <span class="helper-text"><b>Correo</b></span>
                                    <p><?= $row["correo"];?></p>
                                </div>
                                <div class="input-field col s6 m4">
                                        <span class="helper-text"><b>Estado</b></span>
                                        <p><?= $row["estado"];?></p>
                                    </div>
                                    <div class="input-field col s6 m4">
                                        <span class="helper-text"><b>Municipio</b></span>
                                        <p><?= $row["municipio"];?></p>
                                        </select>
                                    </div>
                                <div class="input-field col s12 m12">
                                    <span class="helper-text"><b>Dirección</b></span>
                                    <p><?= $row["direccion"];?></p>
                                </div>
                                <div class="input-field col s6 m12">
                                    <a href="organismos.php" id="atrasOrganismo" style="margin-left:30%" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<?php } // SI LA CONSULTA TRAE REGISTROS ?>  
<?php
    } // SI HAY UN ID EN EL GET
    require_once('footer.php');
?> 
