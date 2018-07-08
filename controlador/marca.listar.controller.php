<?php

require_once '../logica/Marca.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objMarca = new Marca();
    $resultado = $objMarca->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
