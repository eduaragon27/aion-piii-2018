<?php

require_once '../logica/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    /*Recibir la variable POST que le envía la vista*/
    $codigoCargo = $_POST["codigo_cargo"];
    /*Recibir la variable POST que le envía la vista*/
    
    $objSesion = new Sesion();
    $resultadoOpcionesMenuBD = $objSesion->obtenerOpcionesMenu($codigoCargo);
            
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}
