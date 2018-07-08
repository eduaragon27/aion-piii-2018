

<?php

require_once '../logica/Cliente.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    $objCliente = new Cliente();
    $resultado = $objCliente->listar();
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
