<?php
include 'conexion_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $direccion_id = $_POST['direccion_id'];
    $primer_nombre = trim($_POST['primer_nombre']);
    $segundo_nombre = trim($_POST['segundo_nombre']);
    $primer_apellido = trim($_POST['primer_apellido']);
    $segundo_apellido = trim($_POST['segundo_apellido']);

    if ($_POST['fecha_nacimiento_actual'] != $_POST['fecha_nacimiento']) {

        // Comenzamos a calcular la edad con la fecha de nacimiento
        $fecha_nacimiento = $_POST['fecha_nacimiento_actual'];
        // Explode the date to get day, month, and year
        list($day, $month, $year) = explode("/", $fecha_nacimiento);
        // Create a DateTime object for the birth date
        $birthDate = new DateTime("$year-$month-$day");
        // Create a DateTime object for the current date
        $currentDate = new DateTime();
        // Calculate the age using the difference between the current date and the birth date
        $edad = $currentDate->diff($birthDate)->y;
        // Fin calculo de edad
    } else {
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
    }





    $direccion = trim($_POST['direccion']);

    if (!isset($_REQUEST['estado'])) {
        $estado = $_REQUEST['estado_hidden'];
    } else{
        $estado = $_REQUEST['estado'];
    }
    
    if (!isset($_REQUEST['municipio'])) {
        $municipio = $_REQUEST['municipio_hidden'];
    } else{
         $municipio = $_REQUEST['municipio'];
    }
    
    if (!isset($_REQUEST['sexo'])) {
        $sexo = $_REQUEST['sexo_hidden'];
    } else{
         $sexo = $_REQUEST['sexo'];
    }

    

    if (($_FILES['foto_nueva']['name']) == "") {
        $nombreImagenDB = $_REQUEST['foto_actual'];

    } elseif (($_FILES['foto_nueva']['name'])) {
            $nombreArchivo = $_FILES['foto_nueva']['name'];
            $tipoArchivo = $_FILES['foto_nueva']['type'];
            $tamanioArchivo = $_FILES['foto_nueva']['size'];
            $rutaTempArchivo = $_FILES['foto_nueva']['tmp_name'];

            // Definir la carpeta donde se almacenarán las imágenes
            //$carpetaDestino = './img/';
            $carpetaDestino = __DIR__ .'\fotosdetenido\\';

            // Crear un nombre único para la imagen
            $nombreUnico = uniqid() . '_' . $nombreArchivo;

            // Ruta completa donde se almacenará la imagen
            $rutaDestino = $carpetaDestino . $nombreUnico;

            // Mover la imagen a la carpeta de destino
            move_uploaded_file($rutaTempArchivo, $rutaDestino);


            $nombreImagenDB = $conexion->real_escape_string($nombreUnico);
            $rutaImagenDB = $conexion->real_escape_string($rutaDestino);
    } else {
        echo 'No se ha enviado ningún archivo.';
    }

    $sql = "UPDATE
            direcciones
        SET
            estado = '$estado',
            municipio = '$municipio',
            direccion = '$direccion'
        WHERE
            direccion_id = '$direccion_id'";
        $resultado = $conexion->query($sql);

        if ($resultado) {

            $sql ="UPDATE
                detalle_detenidos
            SET
                primer_nombre = '$primer_nombre',
                segundo_nombre = '$segundo_nombre',
                primer_apellido = '$primer_apellido',
                segundo_apellido = '$segundo_apellido',
                fecha_nacimiento = '$fecha_nacimiento',
                edad = '$edad',
                sexo = '$sexo',
                nombre_foto = '$nombreImagenDB'
            WHERE
            detenido_idfk = '$id'";
            $result = $conexion->query($sql);

            header('Location: editar_detenido.php?id='.$id);
        }
}
?>