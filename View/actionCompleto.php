<?php
include('config.php');
date_default_timezone_set("America/Bogota");
setlocale(LC_ALL, 'es_ES');

$metodoAction  = (int) filter_var($_REQUEST['metodo'], FILTER_SANITIZE_NUMBER_INT);

//$metodoAction ==1, es crear un registro nuevo
if($metodoAction == 1){

    $fechaRegistro  = date('d-m-Y H:i:s A', time()); 
    $namefull       = filter_var($_POST['namefull'], FILTER_SANITIZE_STRING);
    $cedula         = (int) filter_var($_POST['cedula'], FILTER_SANITIZE_NUMBER_INT);
    $sexo           = filter_var($_POST['sexo'], FILTER_SANITIZE_STRING);
    $section        = filter_var($_POST['section'], FILTER_SANITIZE_STRING);

    //Informacion de la foto
    $filename       = $_FILES["foto"]["name"]; //nombre de la foto
    $tipo_foto      = $_FILES['foto']['type']; //tipo de archivo
    $sourceFoto     = $_FILES["foto"]["tmp_name"]; //url temporal de la foto
    $tamano_foto    = $_FILES['foto']['size']; //tamaño del archivo (foto)

    //Se comprueba si la foto a cargar es correcto observando su extensión y tamaño, 100000 = 1 Mega 
    if (!((strpos($tipo_foto, "PNG") || strpos($tipo_foto, "jpg") && ($tamano_foto < 100000)))) {
        //código para renombrar la foto 
        $logitudPass 	        = 8;
        $newNameFoto            = substr( md5(microtime()), 1, $logitudPass);
        $explode                = explode('.', $filename);
        $extension_foto         = array_pop($explode);
        $nuevoNameFoto          = $newNameFoto.'.'.$extension_foto;

        //Verificando si existe el directorio, de lo contrario lo creo
        $dirLocal       = "public/fotosPasajeros";
        if (!file_exists($dirLocal)) {
            mkdir($dirLocal, 0777, true);
        }

        $miDir 		      = opendir($dirLocal); //Abro mi  directorio
        $urlFotoPasajero    = $dirLocal.'/'.$nuevoNameFoto; //Ruta donde se almacena la factura.

        //Muevo la foto a mi directorio.
        if(move_uploaded_file($sourceFoto, $urlFotoPasajero)){
            $SqlInsertPasajero = ("INSERT INTO table_pasajeros(
                namefull,
                cedula,
                sexo,
                section,
                foto,
                fechaRegistro
            )
            VALUES(
                '".$namefull."',
                '".$cedula."',
                '".$sexo."',
                '".$section."',
                '".$nuevoNameFoto."',
                '".$fechaRegistro."'
            )");
            $resulInsert = mysqli_query($con, $SqlInsertPasajero);
        }
        closedir($miDir);
        header("Location:index.php?a=1");
    } else {
        header("Location:index.php?errorimg=1");
    }
}

//Actualizar registro del Pasajero
if($metodoAction == 2){
    $idPasajero      = (int) filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);

    $namefull       = filter_var($_POST['namefull'], FILTER_SANITIZE_STRING);
    $cedula         = (int) filter_var($_POST['cedula'], FILTER_SANITIZE_NUMBER_INT);
    $sexo           = filter_var($_POST['sexo'], FILTER_SANITIZE_STRING);
    $section        = filter_var($_POST['section'], FILTER_SANITIZE_STRING);

    $UpdatePasajero    = ("UPDATE table_pasajeros
        SET namefull='$namefull',
        cedula='$cedula', 
        sexo='$sexo', 
        section='$section'
        WHERE id='$idPasajero' ");
    $resultadoUpdate = mysqli_query($con, $UpdatePasajero);

    //Verificando si existe foto del pasajero para actualizar
    if (!empty($_FILES["foto"]["name"])){
        $filename       = $_FILES["foto"]["name"]; //nombre de la foto
        $tipo_foto      = $_FILES['foto']['type']; //tipo de archivo
        $sourceFoto     = $_FILES["foto"]["tmp_name"]; //url temporal de la foto
        $tamano_foto    = $_FILES['foto']['size']; //tamaño del archivo (foto)

        //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
        if (!((strpos($tipo_foto, "PNG") || strpos($tipo_foto, "jpg") && ($tamano_foto < 100000)))) {
            $logitudPass 	        = 8;
            $newNameFoto            = substr( md5(microtime()), 1, $logitudPass);
            $explode                = explode('.', $filename);
            $extension_foto         = array_pop($explode);
            $nuevoNameFoto          = $newNameFoto.'.'.$extension_foto;

            //Verificando si existe el directorio, de lo contrario lo creo
            $dirLocal       = "public/fotosPasajeros";
            $miDir 		      = opendir($dirLocal); //Habro mi  directorio
            $urlFotoPasajero    = $dirLocal.'/'.$nuevoNameFoto; //Ruta donde se almacena la factura.

            //Muevo la foto a mi directorio.
            if(move_uploaded_file($sourceFoto, $urlFotoPasajero)){
                $updateFoto = ("UPDATE table_pasajeros SET foto='$nuevoNameFoto' WHERE id='$idPasajero' ");
                $resultFoto = mysqli_query($con, $updateFoto);
            }
        } else {
            header("Location:index.php?errorimg=1");
        }
    }

    header("Location:formEditar.php?update=1&id=$idPasajero");
}

//Eliminar Pasajero
if($metodoAction == 3){
    $idPasajero  = (int) filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
    $namePhoto = filter_var($_REQUEST['namePhoto'], FILTER_SANITIZE_STRING);

    $SqlDeletePasajero = ("DELETE FROM table_pasajeros WHERE  id='$idPasajero'");
    $resultDeletePasajero = mysqli_query($con, $SqlDeletePasajero);
    
    if($resultDeletePasajero !=0){
        $fotoPasajero = "public/fotosPasajeros/".$namePhoto;
        unlink($fotoPasajero);
    }
    
    $msj ="Pasajero Borrado correctamente.";
    header("Location:index.php?deletPasajero=1&mensaje=".$msj);
}
?>
