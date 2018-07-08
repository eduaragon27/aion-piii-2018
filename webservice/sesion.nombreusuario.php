<?php
require_once '../logica/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if(!isset($_POST["p_email"])){
    Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
    exit;
}

$email = $_POST["p_email"];

try {
    
    $objSesion = new Sesion();
    $objSesion->setEmail($email);
    $resultado = $objSesion->mostrarNombreUsuario();
   if ( $resultado["email"] == $email){
        Funciones::imprimeJSON(200, "Bienvenido a la aplicación", $resultado);
   } else {
       Funciones::imprimeJSON(500, "No se han encontrado coincidencias", $resultado);
   }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



