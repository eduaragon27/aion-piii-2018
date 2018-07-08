<?php

require_once '../logica/Producto.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objProducto = new Producto();
    $resultado = $objProducto->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
