<?php

require_once '../logica/Producto.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if 
        (
            !isset($_POST["p_nom"]) ||
            empty($_POST["p_nom"]) ||
            
            !isset($_POST["p_descrip"]) ||
            empty($_POST["p_descrip"]) ||
            
            !isset($_POST["p_tipo_ope"]) ||
            empty($_POST["p_tipo_ope"]) ||
   
            !isset($_POST["p_precio"]) ||
            empty($_POST["p_precio"])||
            
            !isset($_POST["p_cod_cat"]) ||
            empty($_POST["p_cod_cat"])||
            
            !isset($_POST["p_cod_marca"]) ||
            empty($_POST["p_cod_marca"])||
            
            !isset($_POST["p_estado"]) ||
            empty($_POST["p_estado"]) ||
            
            !isset($_POST["p_stock"]) ||
            empty($_POST["p_stock"])||
            
            !isset($_POST["p_color"]) ||
            empty($_POST["p_color"])||
            
            !isset($_POST["p_cod"]) ||
            empty($_POST["p_cod"])
                   
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }
    
    $nombreProducto     = $_POST["p_nom"];
    $tipoOperacion      = $_POST["p_tipo_ope"];
    $descripcionProducto= $_POST["p_descrip"];
    $precio             = $_POST["p_precio"];
    $codigocategoria    = $_POST["p_cod_cat"];
    $codigomarca        = $_POST["p_cod_marca"];
    $stock              = $_POST["p_stock"];
    $estado             = $_POST["p_estado"];
    $color              = $_POST["p_color"];
    $codigo             = $_POST["p_cod"];

    
    
    $objProducto = new Producto();
    
    $objProducto->setNombreProducto($nombreProducto);
    $objProducto->setDescripcionProducto($descripcionProducto);
    $objProducto->setPrecio($precio);
    $objProducto->setCodigoCategoria($codigocategoria);
    $objProducto->setCodigoMarca($codigomarca);
    $objProducto->setStock($stock);
    $objProducto->setColor($color);
    $objProducto->setEstadoProducto($estado);
    $objProducto->setCodigoProducto($codigo);
    
    if ($tipoOperacion == "agregar"){
        $resultado = $objProducto->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Agregado correctamente", "");
        }
    }else{
        $resultado = $objProducto->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
