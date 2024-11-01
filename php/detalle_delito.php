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
                            <h5>Detalle del Delito</h5></br>
                            <div class="input-field col s6 m4">
                                <span class="helper-text"><b>Código</b></span>
                                <p><?= $row["codigo"];?></p>
                            </div>
                            <div class="input-field col s6 m4">
                                <span class="helper-text"><b>Nombre del Delito</b></span>
                                <p><?= $row["nombre"];?></p>
                            </div>
                            <div class="input-field col s12 m12">
                                <span class="helper-text"><b>Descripción</b></span>
                                <p><?= $row["descripcion"];?></p>
                            </div>
                            <div class="input-field col s6 m12">
                                <a href="delitos.php" id="atrasDelito" style="margin-left:30%" class="waves-effect waves-light btn blue" style="color:#fff" title="Ir atrás">ATRAS<i class="material-icons right">arrow_back</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php   } // SI LA CONSULTA TRAE REGISTROS ?>  
<?php
    } // SI HAY UN ID EN EL GET
require_once('footer.php');
?>
