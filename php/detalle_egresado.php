<?php
require_once('header.php');
include 'conexion_db.php';
        
    // obtener el ID del GET (id del detenido)
    if (isset($_GET['id']) != "" && $_GET['id'] > 0) {
        $detenido_id = $_GET['id'];
    
        // consulta
        $sql = "SELECT d.*, dd.*, dir.*
        FROM detenidos AS d  
        LEFT JOIN detalle_detenidos AS dd ON dd.detenido_idfk = d.detenido_id
        LEFT JOIN direcciones AS dir ON dd.direccion_idfk = dir.direccion_id
        LEFT JOIN detenciones AS det ON det.detenido_idfk = d.detenido_id AND det.oculto = 0
        WHERE d.oculto = 0
        AND d.detenido_id = '$detenido_id'
        GROUP BY d.detenido_id
        ORDER BY d.detenido_id DESC";
        $result = $conexion->query($sql);
        $row = $result->fetch_assoc();
?>
        <?php if (mysqli_num_rows( $result ) > 0) { ?>
        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                        <h4 class="header_h center"><b>Detalle de Datos del Egresado</b></h4>
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
                    </div>
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
                        <?php     // consulta de las detenciones asociadas
                        $sql = "SELECT ed.fecha_egreso, ed.descripcion, te.nombre AS tipo_egreso
                        FROM egreso_detenciones AS ed  
                        LEFT JOIN detenciones AS det ON ed.detencion_idfk = det.detencion_id AND det.oculto = 0
                        LEFT JOIN detenidos AS d ON det.detenido_idfk = d.detenido_id 
                        LEFT JOIN tipo_egresos AS te ON ed.tipoegreso_idfk = te.tipoegreso_id
                        WHERE d.oculto = 0
                        AND d.detenido_id = '$detenido_id'
                        ORDER BY ed.egreso_id DESC";
                        $egresos = $conexion->query($sql);

                        if (mysqli_num_rows($egresos) > 1) { ?>

                        <div class="col s12 m12">
                            <p class="center"><b>Listado de egresos del detenido</b></p><br><hr>
                            <table class="striped highlight centered responsive-table">
                                <thead>
                                    <tr>
                                        <th style="width: 20%">Fecha de Egreso</th>
                                        <th style="width: 30%">Tipo de egreso asociado</th>
                                        <th style="width: 50%">Descripción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($egresos as $egreso) { ?>
                                                <tr class='center'>
                                                    <td style="width: 20%"><?=$egreso["fecha_egreso"]?></td>
                                                    <td style="width: 30%"><?=$egreso["descripcion"]?></td>
                                                    <td style="width: 50%"><?=$egreso["tipo_egreso"]?></td>
                                                </tr>                               
                                    <?php } ?>
                                </tbody>
                            </table><hr>
                        </div>
                        <?php  } else { $egreso = $egresos->fetch_assoc(); ?>
                            <div class="col s12 m12">
                                <p class="center"><b>Datos de egreso del detenido</b></p><br>
                                <div class="col s6 m4 offset-m1">
                                    <span class="helper-text"><b>Fecha de Egreso</b></span>
                                    <p><?= $egreso["fecha_egreso"];?></p>
                                </div>
                                <div class="col s6 m6">
                                    <span class="helper-text"><b>Tipo de egreso asociado</b></span>
                                    <p><?= $egreso["tipo_egreso"];?></p>
                                </div>
                                <div class="col s6 m10 offset-m1"><br>
                                    <span class="helper-text"><b>Descripción</b></span>
                                    <p><?= $egreso["descripcion"];?></p>
                                </div>
                            </div>
                        <?php  } ?>
                    </div>
                    <div class="row"><br><br>
                        <div class="col s6 m12 offset-m1">
                            <a href="lista_egresos.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue center">ATRAS<i class="material-icons right">arrow_back</i></a>
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