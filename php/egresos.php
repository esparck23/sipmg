<?php
require_once('header.php');
include 'conexion_db.php';

    // Paginación
    $registros_por_pagina = 3;
    $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
    $detenido_id = isset($_GET['id']) ? $_GET['id'] : 0;
    $inicio = ($pagina_actual - 1) * $registros_por_pagina;

    // Consulta SQL para obtener los datos de los detenidos DETENIDO
    $sql_egresado = "SELECT * FROM detenciones, egreso_detenciones, tipo_egresos
    WHERE egreso_detenciones.detencion_idfk = detenciones.detencion_id
    AND egreso_detenciones.tipoegreso_idfk = tipo_egresos.tipoegreso_id
    AND detenciones.estatus = 'EGRESADO'
    AND detenciones.detenido_idfk = '$detenido_id'
    ORDER BY egreso_detenciones.egreso_id DESC LIMIT $inicio, $registros_por_pagina"; // ESTATUS DETENIDO AQUELLOS QUE FUERON EGRESADOS
    $resultado_egresado = $conexion->query($sql_egresado);
?>

<div class="row row_principal">
    <!-- DETENIDOS -->
    <div class="col s12 m10 offset-m1">
        <div class="card-panel">
            <?php  if ($resultado_egresado->num_rows > 0) { $cont = 1;?>
            <h6 class="class header_h2 center">Listado de Detenciones Asociadas con Egreso</h6><br>
            <div class="row">
                <div class="col s6 m4 offset-m3">
                    <input class="input-field" type="text" id="expediente" name="expediente" placeholder="Buscar por Expediente" class="validate">
                </div>
                <div class="col s6 m4">
                    <!-- <button class="btn waves-effect waves-light" id="buscarActivoBtn">Buscar</button> -->
                    <a style="display:none;" id="refrescar_consulta" href="#">Refrescar</a>
                </div>
            </div>
            <table class="table striped highlight centered responsive-table" id="tabla_egresos_detenido">
                <thead>
                    <tr style="font-size: 14px;">
                        <th>Nro.</th>
                        <th>Expediente</th>
                        <th>Estatus</th>
                        <th>Tipo de Egreso</th>
                        <th>Fecha de Egreso</th>
                        <th class="center">Acciones</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px;" id="tabla">
                    <?php while ($fila = $resultado_egresado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $cont++; ?></td>
                        <td><?= $fila['numero']?></td>
                        <td><?= $fila['estatus']?></td>
                        <td><?= $fila['nombre']?></td>
                        <td><?= $fila['fecha_egreso']?></td>
                        <td>
                            <a href="detalle_egreso.php?id=<?= $fila['detencion_id']; ?>" title="Ver detalle" class="btn btn-floating waves-effect waves-light blue"><i class="material-icons">info</i></a>
                            </td>
                    </tr>
                    <?php endwhile;?>
                </tbody>
            </table><hr><br/>
            <div class="pagination" id="paginador">
                <ul class="center-align">
                <?php   $sql = "SELECT COUNT(*) AS TOTAL FROM detenciones WHERE detenciones.estatus = 'EGRESADO' AND detenciones.detenido_idfk = $detenido_id";
                        $resultado = $conexion->query($sql);
                        $fila = $resultado->fetch_assoc();
                        $total_registros = $fila['TOTAL'];
                        $total_paginas = ceil($total_registros / $registros_por_pagina);

                        // Calcula si se deben mostrar las flechas de izquierda y derecha
                        $mostrar_flecha_izquierda = $pagina_actual > 1;
                        $mostrar_flecha_derecha = $pagina_actual < $total_paginas;
                        
                    if ($mostrar_flecha_izquierda) {
                        echo "<li class='waves-effect'><a href='?id=".$detenido_id."&pagina=" . ($pagina_actual - 1)."'><i class='material-icons'>chevron_left</i></a></li>";
                    }
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        $active = ($i == $pagina_actual) ? "active" : "";
                        echo "<li class='waves-effect $active'><a href='?id=".$detenido_id."&pagina=$i'>$i</a></li>";
                    }
                    if ($mostrar_flecha_derecha) {
                        echo "<li class='waves-effect'><a href='?id=".$detenido_id."&pagina=" . ($pagina_actual + 1) . "'><i class='material-icons'>chevron_right</i></a></li>";
                    }
                ?>
                </ul>
            </div>
            <div class="row">
                <div class="input-field col s6 m6 offset-m1">
                    <a href="consulta.php" style="color:#fff" title="Ir atrás" id="atras" class="waves-effect waves-light btn blue">ATRAS<i class="material-icons right">arrow_back</i></a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>