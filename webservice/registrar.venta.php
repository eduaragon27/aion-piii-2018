<?php
require_once '../logica/Venta.class.php';
require_once '../util/funciones/Funciones.clase.php';

if (
            !isset($_POST["p_dni_cliente"]) ||
            empty($_POST["p_dni_cliente"]) ||
            
            !isset($_POST["p_dni_usuario"]) ||
            empty($_POST["p_dni_usuario"])||
            
            !isset($_POST["p_latitud"]) ||
            empty($_POST["p_latitud"])||
            
             !isset($_POST["p_longitud"]) ||
            empty($_POST["p_longitud"])||
            
            !isset($_POST["p_direccion"]) ||
            empty($_POST["p_direccion"])||
            
            !isset($_POST["p_celular"]) ||
            empty($_POST["p_celular"])||
                    
            !isset($_POST["p_detalle_venta"]) ||
            empty($_POST["p_detalle_venta"])
            
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }

try {
    
    $obj = new Venta();
    $obj->setDniCliente($_POST["p_dni_cliente"]);
    $obj->setDniUsuario($_POST["p_dni_usuario"]);
    $obj->setLatitud($_POST["p_latitud"]);
    $obj->setLongitud($_POST["p_longitud"]);
    $obj->setDireccion($_POST["p_direccion"]);
    $obj->setCelular($_POST["p_celular"]);
    $obj->setDetalleVenta($_POST["p_detalle_venta"]);
    $respuesta = $obj->registrarVenta();
    if ($respuesta["resultado"]==1){
        Funciones::imprimeJSON(200, "La venta se ha registrado correctamente", "")  ;   
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}



