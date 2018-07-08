<?php

require_once '../logica/Marca.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if 
        (
            !isset($_POST["p_cod"]) ||
            empty($_POST["p_cod"]) ||
            
            !isset($_POST["p_tipo_ope"]) ||
            empty($_POST["p_tipo_ope"]) ||
   
            !isset($_POST["p_desc"]) ||
            empty($_POST["p_desc"])
            
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }
    
    $codigo             = $_POST["p_cod"];
    $descripcion        = $_POST["p_desc"];
    $tipoOperacion      = $_POST["p_tipo_ope"];
    

    
    
    $objMarca = new Marca();
    
    $objMarca->setCodigoMarca($codigo);
    $objMarca->setNombreMarca($descripcion);
        
    if ($tipoOperacion == "agregar"){
        $resultado = $objMarca->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Agregado correctamente", "");
        }
    }else{
        $resultado = $objMarca->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
