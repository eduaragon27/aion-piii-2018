<?php

require_once '../util/funciones/Funciones.clase.php';

session_name("aion");
session_start();


if ( ! isset($_SESSION["nombre_usuario"])){
    Funciones::mensaje("Usted no ha iniciado sesión", "e", "index.html", 5);
    exit;
}
//Almacenar los datos del usuario que estan en la sesión
$s_nombreUsuario = $_SESSION["nombre_usuario"];
$s_dniUsuario = $_SESSION["dni_usuario"];
$s_codigoCargo = $_SESSION["codigo_cargo"];
$s_foto = $_SESSION["foto_usuario"];

/*Mostrar la foto que le corresponde a cada usuario*/
/*En el caso de que el usuario no tenga asignada una foto, se mostrará una foto por default*/
//$foto = $s_codigoUsuario;
/*
if (file_exists("../fotos/" . $foto . ".png" )){
    $s_foto = "../fotos/" . $foto . ".png";
    
}else if (file_exists("../fotos/" . $foto . ".jpg" )){
    $s_foto = "../fotos/" . $foto . ".jpg";
    
}else{
    $s_foto = "../fotos/default.jpg";
}

*/