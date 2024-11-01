<?php
require_once('header.php');
include 'conexion_db.php';
        
    // obtener el ID del GET (id del detenido)
    $detencion_id = isset($_GET['id']) ? $_GET['id'] : 0;

    // Consulta SQL para obtener los datos
    $sql = "SELECT *, organismos.nombre AS organismo, delitos.nombre AS delito, tipo_egresos.nombre AS tipo_egreso, egreso_detenciones.descripcion AS descripcion_egreso
	FROM detenciones, egreso_detenciones, detalle_detenciones, organismos, delitos, direcciones, tipo_egresos
    WHERE egreso_detenciones.detencion_idfk = detenciones.detencion_id
    AND detalle_detenciones.detencion_idfk = detenciones.detencion_id
    AND direcciones.direccion_id = detalle_detenciones.direccion_idfk
    AND organismos.organismo_id = detenciones.organismo_idfk
    AND delitos.delito_id = detenciones.delito_idfk
    AND egreso_detenciones.tipoegreso_idfk = tipo_egresos.tipoegreso_id
    AND egreso_detenciones.detencion_idfk = '$detencion_id' ORDER BY egreso_detenciones.detencion_idfk DESC;";
    $resultado = $conexion->query($sql);
    $row = $resultado->fetch_assoc();
?>

<div class="row row_principal">
    <div class="col s12 m10 offset-m1">
                <h4 class="header_h center"><b>Detalle de Datos del Egreso</b></h4>
        <div class="card-panel">
            <div class="row">
                <div class="col s4 m4 offset-m1">
                    <span class="helper-text"><b>Fecha de Egreso</b></span>
                    <!-- <input disabled id="cedula" type="number" class="validate" value="" required="true" filter="text"/> -->
                    <p><?= $row["fecha_egreso"];?></p>
                </div>
                <div class="col s4 m4">
                    <span class="helper-text"><b>Tipo Egreso</b></span>
                    <p><?= $row["nombre"];?></p>
                </div>
            </div><br>
            <div class="row">
                <div class="col s4 m10 offset-m1">
                    <span class="helper-text"><b>Descripción</b></span>
                    <p><?= $row["descripcion_egreso"];?></p>
                </div>
            </div><br>
            <div class="row">
                <div class="col s4 m10 offset-m1">
                    <p class="center"><b>Detalles de la Detención Asociada</b></p><br>
                </div>
                <div class="col s4 m4 offset-m1">
                    <span class="helper-text"><b>Expediente</b></span>
                    <p><?= $row["numero"];?></p>
                </div>
                <div class="col s4 m3">
                    <span class="helper-text"><b>Estatus</b></span>
                    <p><?= $row["estatus"];?></p>
                </div>
                <div class="col s4 m3">
                    <span class="helper-text"><b>Fecha de Ingreso</b></span>
                    <p><?= $row["fecha_ingreso"];?></p>
                </div>
            </div>
            <div class="row"><br>
                <div class="col s4 m2 offset-m1">
                    <span class="helper-text"><b>Delito</b></span>
                    <p><?= $row["delito"];?></p>
                </div>
                <div class="col s4 m8">
                    <span class="helper-text"><b>Descipción del delito/ aprehensión</b></span>
                    <p><?= $row["descripcion"];?></p>
                </div>
            </div>
            <div class="row">
                <div class="col s4 m3 offset-m1">
                    <span class="helper-text"><b>Lugar de Referencia</b></span>
                    <p><?= $row["lugar"];?></p>
                </div>
                <div class="col s4 m5">
                    <span class="helper-text"><b>Dirección de aprehensión</b></span>
                    <p><?php echo $dir = ($row["direccion"] != "") ? $row["direccion"].", ".$row["municipio"].", ".$row["estado"]."." : "N/A";?></p>
                </div>
                <div class="col s12 m3">
                    <span class="helper-text"><b>Organismo</b></span>
                    <p><?= $row["organismo"];?></p>
                </div>
            </div><br>
            <div class="row">
                <div class="input-field col s6 m6 offset-m1">
                    <a href="lista_egresos.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once('footer.php');
?> 