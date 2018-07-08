<?php

require_once '../logica/Categoria.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if 
        (
              
            !isset($_POST["p_nom"]) ||
            empty($_POST["p_nom"])||
            
            !isset($_POST["p_tipo_ope"]) ||
            empty($_POST["p_tipo_ope"]) ||
            
            !isset($_POST["p_color"]) ||
            empty($_POST["p_color"])||
            
             !isset($_POST["p_cod"]) ||
            empty($_POST["p_cod"]) 
            
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }
    
    $codigo             = $_POST["p_cod"];
    $descripcion        = $_POST["p_nom"];
    $tipoOperacion      = $_POST["p_tipo_ope"];
    $controlaColor      = $_POST["p_color"];
    

    
    
    $objCategoria = new Categoria();
    
    $objCategoria->setCodigoCategoria($codigo);
    $objCategoria->setNombreCategoria($descripcion);
    $objCategoria->setRequiereColor($controlaColor);
        
    if ($tipoOperacion == "agregar"){
        $resultado = $objCategoria->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Agregado correctamente", "");
        }
    }else{
        $resultado = $objCategoria->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
