<?php
require_once '../logica/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if(!isset($_POST["txtemail"]) || ! isset($_POST["txtclave"])){
    Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
    exit;
}

$email = $_POST["txtemail"];
$clave = $_POST["txtclave"];

try {
    
    $objSesion = new Sesion();
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);

    $resultado = $objSesion->validarSesion();
   
    /*Obtener la foto del usuario*/
    $foto= $objSesion->obtenerFoto($resultado["dni_usuario"]);
    $resultado["foto"]= $foto;
    /*Obtener la foto del usuario*/
    
    /*Generar el token de seguridado*/
    require_once 'token.generar.php';
    $token= generarToken(null, 60*60);
    $resultado["token"]= $token;
    /*Generar el token de seguridado*/
        
  
    
    if($resultado["estado"]==200){
    unset($resultado["estado"]);
        //Funciones::imprimeJSON(200, "Bienvenido a la aplicación", $resultado);
        // print_r($resultado)
        session_name("aion");
                        session_start();
                        $_SESSION["nombre_usuario"] = $resultado["nombre_usuario"];
                        $_SESSION["dni_usuario"] = $resultado["dni_usuario"];
                        $_SESSION["email_usuario"] = $resultado["email_usuario"];
                        $_SESSION["codigo_cargo"] = $resultado["codigo_cargo"];
                        $_SESSION["foto_usuario"] = $resultado["foto"];
                        
        Funciones::mensaje("Bienvenido a la aplicación", "i", "../vista/menu.principal.view.php", 2);
        
        //header("location:../vista/menu.principal.view.php");
 
      
    }else{
        //Funciones::imprimeJSON(500, $resultado["nombre_usuario"], $resultado);
        Funciones::mensaje("Datos Incorrectos", "e", "../vista/index.html", 5);
    }
    
    //print_r($resultado);
    
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



