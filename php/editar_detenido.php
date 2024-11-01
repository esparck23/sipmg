<?php
require_once('header.php');
include 'conexion_db.php';
    $pg = '';
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pg'])) {
        $pg = $_GET['pg'];
    }

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];

            // Consulta SQL para obtener los datos
            $sql = "SELECT  d .*,  dd .*,  dir .*
            FROM  detenidos  AS  d  
            LEFT JOIN  detalle_detenidos  AS  dd  ON  dd . detenido_idfk  =  d . detenido_id  
            LEFT JOIN  direcciones  AS  dir  ON  dd . direccion_idfk  =  dir . direccion_id WHERE d.detenido_id = '$id'";
            $resultado = $conexion->query($sql);
            $row = $resultado->fetch_assoc();

?>
        <?php if (mysqli_num_rows( $resultado ) > 0) { ?>
        <div class="row row_principal">
            <div class="col s12 m10 offset-m1">
                <h4 class="class header_h2">Editar datos de detenido</h4><br>
                <form method="POST" accept-charset="utf-8" action="detenido_editado.php" id="formEditarDetenido" enctype="multipart/form-data">
                    <div class="input-field col s6 m3">
                        <input id="primer_nombre" name="primer_nombre" value="<?= $row['primer_nombre']; ?>" type="text" required="true" class="validate" filter="text">
                        <label for="primer_nombre">Primer Nombre</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input id="segundo_nombre" name="segundo_nombre" value="<?= $row['segundo_nombre']; ?>" type="text" required="true" class="validate" filter="text">
                        <label for="segundo_nombre">Segundo Nombre</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input id="primer_apellido" name="primer_apellido" value="<?= $row['primer_apellido']; ?>" type="text" required="true" class="validate" filter="text">
                        <label for="primer_apellido">Primer Apellido</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input id="segundo_apellido" name="segundo_apellido" value="<?= $row['segundo_apellido']; ?>" type="text" required="true" class="validate" filter="text">
                        <label for="segundo_apellido">Segundo Apellido</label>
                    </div>
                    <div class="input-field col s6 m4">
                        <input id="fecha_nacimiento" value="<?= $row['fecha_nacimiento']; ?>" type="hidden">
                        <input type="text" name="fecha_nacimiento_actual" id="fecha_nacimiento_actual" required="true" class="validate" filter="text" value="<?= $row['fecha_nacimiento']; ?>">
                        <label for="fecha_nacimiento_actual">Fecha de Nacimiento</label>
                    </div>
                    <div class="input-field col s6 m3">
                        <input type="hidden" name="sexo_hidden" id="sexo_hidden" value="<?= $row['sexo']; ?>">
                        <select id="sexo" class="validate" name="sexo" required="true">
                            <?php $feme = "2"; $mas = "1"; ?>

                            <?php if ($row['sexo'] == $feme) {  ?>
                            <option value="<?= $row['sexo']; ?>" disabled selected>F</option>
                            <option value="1">M</option>

                            <?php } elseif ($row['sexo'] == $mas) { ?>
                            <option value="<?= $row['sexo']; ?>" disabled selected>M</option>
                            <option value="2">F</option>
                                <?php } ?>
                        </select>
                        <label for="sexo">Sexo</label>
                    </div>
                    <div class="input-field  col s6 m5">
                        <input type="hidden" name="estado_hidden" id="estado_hidden" value="<?= $row['estado']; ?>">

                        <select id="estado" name="estado" required>
                            <option value="" disabled>Seleccione un estado</option>
                            <option value="<?= $row['estado']; ?>" selected><?= $row['estado']; ?></option>
                        </select>
                        <label>Estado</label>
                    </div>
                    <div class="input-field  col s6 m4">
                        <input type="hidden" name="municipio_hidden" id="municipio_hidden" value="<?= $row['municipio']; ?>">

                        <select id="municipio" name="municipio" required>
                            <option value="<?= $row['municipio']; ?>" selected><?= $row['municipio']; ?></option>
                        </select>
                        <label>Municipio</label>
                    </div>
                    <div class="input-field col s6 m8">
                        <input type="hidden" name="direccion_id" id="direccion_id" value="<?= $row['direccion_id'] ?>">
                        <input id="direccion" name="direccion" value="<?= $row['direccion']; ?>" type="text" required="true" class="validate" filter="text">
                        <label for="direccion">Dirección</label>
                    </div>
                    <div class="col s4 m6">
                        <span class="helper-text"><b>Foto actual</b></span>
                    </div>
                    <?php if ($row["nombre_foto"]) {?> 

                    <div class="col s4 m8 offset-m2">
                        <span class="center"><img src="fotosdetenido/<?php echo $row["nombre_foto"];?>" alt="Foto del Detenido" height="200px" width="250px" style="border-style:inset;border-color:#67b379;"></span>
                        <input type="hidden" name="foto_actual" id="foto_actual" value="<?php echo $row["nombre_foto"];?>">
                    </div>
                    <div class="col s4 m12">
                        <span class="helper-text "><b>Adjunte nueva Foto del Detenido si desea cambiarla. Por defecto se mantendrá la foto actual</b></span>
                    </div>
                    <div class="col s4 m9 offset-m2">
                        <div class="file-field input-field">
                            <div class="waves-effect btn red">
                                <span>Cargar foto</span>
                                <input type="file" class="validate" required="true" name="foto_nueva" id="foto_nueva" accept="image/*">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" id="campo_foto" type="text" placeholder="Formatos: PNG, JPG, JPEG. Peso: 500 KB">
                                <div id="errores"></div>
                            </div>
                        </div>
                    </div>
                    <?php  } else { ?> 
                    <div class="col s4 m8 offset-m2">
                        <span class="center"><b>N/A</b></span>
                    </div>
                    <div class="col s4 m12">
                        <span class="helper-text "><b>Adjunte Foto del Detenido</b></span>
                    </div>
                    <div class="col s4 m9 offset-m2">
                        <div class="file-field input-field">
                            <div class="waves-effect btn red">
                                <span>Cargar foto</span>
                                <input type="file" class="validate" name="foto_nueva" id="foto_nueva" accept="image/*">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" id="campo_foto" type="text" placeholder="Formatos: PNG, JPG, JPEG. Peso: 500Kb">
                                <div id="errores"></div>
                            </div>
                        </div>
                    </div>
                    <?php  } ?>
                    <div class="row">
                        <div class="col s12 m6" style="margin-top:10%">
                            <input type="hidden" name="id" id="detenido_id" value="<?= $id ?>">
                            <span id="mensaje_campos"  style="color:red" class="helper-text" data-error="wrong" data-success="right"></span>
                            
                            <?php if ($pg == "egreso") { ?> 
                            <a href="lista_egresos.php" title="Ir atrás" style="color:#fff" id="atras_egreso" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                            <?php } else { ?>
                                <a href="consulta.php" style="color:#fff" title="Ir atrás" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                                <?php } ?>
                        </div>
                        <div class="col s12 m6" style="margin-top:10%">
                            <button id="editarDetenido" class="waves-effect waves-light btn green right" type="button">Guardar cambios<i class="material-icons right">done</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php } // SI LA CONSULTA TRAE REGISTROS ?> 
<?php
    } // SI LLEGA EL ID POR EL URL MUESTRA LOS DATOS, SINO OCULTA TODO.

require_once('footer.php');
?>