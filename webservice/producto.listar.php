<?php

require_once '../logica/Producto.clase.php';
require_once '../util/funciones/Funciones.clase.php';

require_once './token.validar.php';

if (! isset($_POST["token"])){
    Funciones::imprimeJSON(500,"Debe especificar el token de seguridad", "");
    exit(); //Deniene el avance de la aplicación
}

/*Recibir Token*/
$token = $_POST["token"];

try {
    if(validarToken($token)){
    //token es valido
     $objProducto = new Producto();
     $resultado = $objProducto->listar();
    }
    /*Obtener la foto para cada producto*/
    for ($i = 0; $i < count($resultado); $i++) {
        $codigoProducto = $resultado[$i]["codigo_producto"];
        $foto = $objProducto->obtenerFoto($codigoProducto);
        $resultado[$i]["foto"]=$foto;
    }
    
    //imprimir el resultado
    Funciones::imprimeJSON(200, "", $resultado);
 
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
