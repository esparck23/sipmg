<?php
require_once('header.php');
include 'conexion_db.php';
        
    // obtener el ID del GET (id del detenido)}
    if (isset($_GET['id']) != "" && $_GET['id'] > 0) {
        $detenido_id = $_GET['id'];

        $sql = "SELECT * FROM
                    detenciones, detenidos, detalle_detenidos, direcciones
                WHERE detenciones.estatus = 'DETENIDO'
                    AND detenidos.detenido_id = '$detenido_id'
                    AND detalle_detenidos.detenido_idfk = detenidos.detenido_id
                    AND direcciones.direccion_id = detalle_detenidos.direccion_idfk
                ORDER BY
                    detenidos.detenido_id DESC";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();
?>
        <?php if (mysqli_num_rows( $result ) > 0) { ?>

        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                        <h4 class="header_h center"><b>Detalle de Datos del Detenido</b></h4>
                <div class="card-panel">
                    <div class="row">
                        <div class="col s6 m2 offset-m1">
                            <span class="helper-text"><b>Cédula de Identidad</b></span>
                            <!-- <input disabled id="cedula" type="number" class="validate" value="" required="true" filter="text"/> -->
                            <p><?php echo $nac = ($row["ciudadano_idfk"]== "1") ? "V-".$row["cedula"] : "E-".$row["cedula"]; ?></p>
                        </div>
                        <div class="col s6 m3">
                            <span class="helper-text"><b>Primer Nombre</b></span>
                            <p><?= $row["primer_nombre"];?></p>
                        </div>
                        <div class="col s6 m3">
                            <span class="helper-text"><b>Segundo Nombre</b></span>
                            <p><?= $row["segundo_nombre"];?></p>
                        </div>
                        <div class="col s6 m3">
                            <span class="helper-text"><b>Primer Apellido</b></span>
                            <p><?= $row["primer_apellido"];?></p>
                        </div>
                    </div>
                    <div class="row"><br>
                        <div class="col s6 m3 offset-m1">
                            <span class="helper-text"><b>Segundo Apellido</b></span>
                            <p><?= $row["segundo_apellido"];?></p>
                        </div>
                        <div class="col s6 m3">
                            <span class="helper-text"><b>Fecha de Nacimiento</b></span>
                            <p><?= $row["fecha_nacimiento"];?></p>
                        </div>
                        <div class="col s6 m2">
                            <span class="helper-text"><b>Edad</b></span>
                            <p><?= $row["edad"];?></p>
                        </div>
                        <div class="col s6 m2">
                            <span class="helper-text"><b>Sexo</b></span>
                            <p><?= $retVal = ($row['sexo'] == '1') ? 'M' : 'F';?></p>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <span class="helper-text"><b>Dirección</b></span>
                            <p><?php echo $dir = ($row["direccion"] != "") ? $row["direccion"].", ".$row["municipio"].", ".$row["estado"]."." : "N/A";?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4 m6 offset-m1">
                            <span class="helper-text"><b>Foto</b></span>
                        </div>
                        <div class="col s4 m8 offset-m4">
                            <?php if ($row["nombre_foto"]) {?> 
                            <span class="center"><img src="fotosdetenido/<?= $row["nombre_foto"];?>" alt="Foto del Detenido" height="200px" width="250px" style="border-style:inset;border-color:#67b379;"></span>
                            <?php } else { ?>
                            <span class="center"><b>N/A</b></span>
                            <?php  } ?> 
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col s6 m12 offset-m1">
                            <a href="consulta.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue center">ATRAS<i class="material-icons right">arrow_back</i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php } // SI LA CONSULTA TRAE REGISTROS ?>  
<?php
    } // SI HAY UN ID EN EL GET
require_once('footer.php');
?> 