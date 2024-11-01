<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SIPMG- Ingreso</title>  
        <link rel="stylesheet" href="css/materialize.min.css">
        <!-- <link rel="stylesheet" href="css/estilos.css"> -->
        <link rel="icon" type="image/vnd.icon" href="img/policiamg.ico">
        <script src="js/jquery-3.4.0.min.js"></script>  
        <script src="js/materialize.min.js"></script> 
        <script src="js/script.js"></script>
        <script src="js/valida.2.1.7.min.js"></script>
        <style>
            body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            }

            main {
            flex: 1 0 auto;
            }

            body {
            background: #fff;
            background-color: #9fae92;
            }

            .input-field input[type=date]:focus + label,
            .input-field input[type=text]:focus + label,
            .input-field input[type=email]:focus + label,
            .input-field input[type=password]:focus + label {
            color: #e91e63;
            }

            .input-field input[type=date]:focus,
            .input-field input[type=text]:focus,
            .input-field input[type=email]:focus,
            .input-field input[type=password]:focus {
            border-bottom: 2px solid #e91e63;
            box-shadow: none;
            }
        </style>
    </head>
    <body>
        <main>
        <div class="row">
            <center>
                <img class="responsive-img" style="width: 150px; height: 150px;" src="img/policiamg.png" />
                <p class="bold" style="font-size: 22px;text-transform: uppercase;-WEBKIT-TEXT-STROKE: MEDIUM;">S I P M G</p>
                <div class="container">
                <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 0px 48px 0px 48px; border: 3px solid #66b177;">
                <form class="col s12" action="php/login.php" method="POST" id="form_login">
                <div class='row'>
                    <?php echo $retVal = (isset($_GET["error"]) == '1') ? '<p class="red">Datos de acceso incorrectos</p>' : '<p></p>' ; ?>
                </div>
                <div class='row'>
                <div class='input-field col s12'>
                <input class='validate' type='email' name='usuario' id='user' class="validate" required="true" filter="text"/>
                <label for='user'>Ingrese el Usuario</label>
                </div>
                </div>

                <div class='row'>
                <div class='input-field col s12'>
                <input class='validate' type='password' name='clave' id='password' class="validate" required="true" filter="text"/>
                <label for='password'>Ingrese la Contraseña</label>
                </div>
                <label style='float: right;'>
                <a href="javascript:void(0)" title="Contacte con el administrador del sistema"><b>¿Olvidó su contraseña?</b></a>
                </label>
                </div>
                <center>
                <div class='row'>
                <button type='submit' name='btn_login' class='col s12 btn btn-large waves-effect indigo'>Acceder</button>
                </div>
                </center>
                </form>
                </div>
                </div>
            </center>
        </div>
        </main>
    </body>
</html>