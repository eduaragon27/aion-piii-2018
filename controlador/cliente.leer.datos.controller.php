<?php
require_once '../logica/Cliente.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    if 
        (

            !isset($_POST["p_cod"]) ||
            empty($_POST["p_cod"]) 
            
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }
    $codigo =$_POST["p_cod"];
    
    $objCliente = new Cliente();
    $resultado =$objCliente->leerDatos($codigo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(),"");
}
