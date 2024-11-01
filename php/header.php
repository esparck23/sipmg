<?php
    include_once 'conexion_db.php';
    
    $res = isset($_GET['res']);
    session_start();

    if (isset($_SESSION['r_usuario']) && isset($_SESSION['nombre']) && isset($_SESSION['nombre_rol'])){
        $r_usuario = json_decode($_SESSION['r_usuario']);
        $nombre_rol = json_decode($_SESSION['nombre_rol']);
        $nombre_u = json_decode($_SESSION['nombre']);
    }
    else {
        header("location: ../index.php"); // si no tiene session activa, lo devuelve al inicio
    }
?>
<!DOCTYPE html> 
<html lang="es">
    <head>
        <meta charset="UTF-8">  
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../img/policiamg.ico" />
        <link rel="stylesheet" type="text/css" href="../css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css"> 
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui.theme.min.css"> 
        <link rel="stylesheet" type="text/css" href="../css/estilos.css">
        <link rel="stylesheet" href="../css/iconfont/material-icons.css">
        <title>SIPMG</title>
    </head>
    <body>
        <header>
            <div class="navbar-fixed">
                <nav class="top-nav" style="background-color:#67b379;border-bottom: 1px solid #010259;padding-bottom:70px">
                    <div class="nav-wrapper">
                        <div class="row">
                            <ul>
                                <li style="padding-left:5px" class="left header_h"><h4 style="color:#000248">SIPMG <small>Sistema de Información de la Policía Municipal de Guaicaipuro</small></h4></li>
                                <li class="header_h" style="text-align:center"></li>
                                <li class="right"><img class="responsive-img" style="width: 80px;" src="../img/policiamg.png" /></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="container">
                <input type="text" style="display:none" id="r_usuario_id" value="<?php echo $r_usuario ?>">
            </div>
        </header>
        <main>
            <div class="nav-wrapper">
                <?php
                if ($res == 1) {
                    echo '<div style="float:right;position:relative;padding:10px 20px 10px 0px;">Registro exitoso</div>';
                } else if ($res == 2) {
                    echo '<div style="float:right;position:relative;padding:10px 20px 10px 0px;">Ocurrió un error, intente nuevamente</div>';
                }
                ?>
                <aside style="position:fixed;width:100px;left:180px;z-index:999;height:auto;">
                    <ul id="slide-out" class="sidenav sidenav-fixed" style="top:72px;overflow:hidden;height:100%;transform: translateX(0px);">
                        <li class="user-details" style="padding:15px 0 0 15px;">
                            <div class="row">
                                <div class="col s12 m12">
                                    <p style="font-weight:600;font-size:18px;"><?php echo $nombre_u."&nbsp;</br><small>Funcionario&nbsp;". $nombre_rol."</small>"?></p>
                                </div>
                            </div>
                            <div class="divider"></div>
                        </li>
                        <li class="no-padding">
                            <ul class="collapsible expandable">
                                <li class="bold"><a class="collapsible-header waves-teal">Detenidos</a>
                                    <div class="collapsible-body" style="display:none">
                                        <ul>
                                            <li><a href="consulta.php">Listado</a></li>
                                            <li class="revocarAccesoPorPermisosDenegados"><a href="registro_detenido.php">Registrar Detenido</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="bold"><a class="collapsible-header waves-teal">Detenciones</a>
                                    <div class="collapsible-body" style="display:none;">
                                        <ul>
                                            <li><a href="lista_detenciones.php">Listado</a></li>
                                            <li class="revocarAccesoPorPermisosDenegados"><a href="registro_detencion.php">Registrar Detención</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="bold"><a class="collapsible-header waves-teal">Delitos</a>
                                    <div class="collapsible-body" style="display:none;">
                                        <ul>
                                            <li><a href="delitos.php">Listado</a></li>
                                            <li class="revocarAccesoPorPermisosDenegados"><a href="registro_delito.php">Registrar Delito</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li id="permiso_organismo" class="bold"><a class="collapsible-header waves-teal">Organismos</a>
                                    <div class="collapsible-body" style="display:none;">
                                        <ul>
                                            <li><a href="organismos.php">Listado</a></li>
                                            <li class="revocarAccesoPorPermisosDenegados"><a href="registro_organismo.php">Registrar Organismo</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li id="permiso_organismo" class="bold"><a class="collapsible-header waves-teal">Egresos</a>
                                    <div class="collapsible-body" style="display:none;">
                                        <ul>
                                            <li><a href="lista_egresos.php">Listado</a></li>
                                            <li class="revocarAccesoPorPermisosDenegados"><a href="registro_egreso.php">Registrar Egreso</a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="bold"><a class="waves-teal collapsible-header" href="logout.php">Salir</a></li>
                            </ul>
                        </li>
                    </ul>
                    <a href="#" style="position:absolute;left:-170px;margin-top:10px" data-target="slide-out" class="nav-wrapper sidenav-trigger btn-floating btn-medium waves-effect waves-light hide-on-large-only">MENU</a>
                </aside>
                <div class="container" style="padding:0 0.5rem;width:100%;">
                
                    
        