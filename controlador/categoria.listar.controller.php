<?php

require_once '../logica/Categoria.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objCategoria = new Categoria();
    $resultado = $objCategoria->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
