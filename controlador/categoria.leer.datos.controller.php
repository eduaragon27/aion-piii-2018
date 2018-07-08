<?php
require_once '../logica/Categoria.class.php';
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
    
    $objCategoria = new Categoria();
    $resultado =$objCategoria->leerDatos($codigo);
    
    Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(),"");
}
