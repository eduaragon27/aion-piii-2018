<?php
require_once '../logica/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if(!isset($_POST["p_email"]) || ! isset($_POST["p_clave"])){
    Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
    exit;
}

$email = $_POST["p_email"];
$clave = $_POST["p_clave"];

try {
    
    $objSesion = new Sesion();
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);

    $resultado = $objSesion->validarSesion();
   
    /*Obtener la foto del usuario*/
    $foto= $objSesion->obtenerFoto($resultado["codigo_usuario"]);
    $resultado["foto"]= $foto;
    /*Obtener la foto del usuario*/
    
    /*Generar el token de seguridado*/
    require_once 'token.generar.php';
    $token= generarToken(null, 60*60);
    $resultado["token"]= $token;
    /*Generar el token de seguridado*/
    
    if($resultado["estado"]==200){
    unset($resultado["estado"]);
        Funciones::imprimeJSON(200, "Bienvenido a la aplicación", $resultado);
    }else{
        Funciones::imprimeJSON(500, $resultado["nombre_usuario"], $resultado);
    }
    
    print_r($resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");

}