<?php
$usuario = "root";
$password = "";
$servidor = "localhost";
$basededatos = "crud_php";

$con = mysqli_connect($servidor, $usuario, $password) or die("No se ha podido conectar al Servidor");
$db = mysqli_select_db($con, $basededatos) or die("Upps! Error en conectar a la Base de Datos");

// Agregar esta línea para seleccionar la base de datos
mysqli_select_db($con, $basededatos);

?>
