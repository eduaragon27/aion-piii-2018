
<?php

require_once '../logica/Cliente.class.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
    if 
        (
            !isset($_POST["p_cod"]) ||
            empty($_POST["p_cod"])||
                        
            !isset($_POST["p_ape_pat"]) ||
            empty($_POST["p_ape_pat"]) ||
            
            !isset($_POST["p_ape_mat"]) ||
            empty($_POST["p_ape_mat"]) ||
            
            !isset($_POST["p_tipo_ope"]) ||
            empty($_POST["p_tipo_ope"]) ||
   
            !isset($_POST["p_nom"]) ||
            empty($_POST["p_nom"])||
            
            !isset($_POST["p_direccion"]) ||
            empty($_POST["p_direccion"])||
            
            !isset($_POST["p_tel_fij"]) ||
            empty($_POST["p_tel_fij"])||
            
            !isset($_POST["p_tel_mov"]) ||
            empty($_POST["p_tel_mov"])||
            
            !isset($_POST["p_email"]) ||
            empty($_POST["p_email"])
            
        )
    {
            Funciones::imprimeJSON(500, "Falta completar datos", "");
            exit();
    }
    
    
    $codigo        = $_POST["p_cod"];
    $apellidoPaterno             = $_POST["p_ape_pat"];
    $apellidoMaterno             = $_POST["p_ape_mat"];
    $tipoOperacion      = $_POST["p_tipo_ope"];
    $nombre             = $_POST["p_nom"];
    $direccion    = $_POST["p_direccion"];
    $telefonoFijo           = $_POST["p_tel_fij"];
    $telefonoMovil            = $_POST["p_tel_mov"];
    $email             = $_POST["p_email"];

    
    
    $objCliente = new Cliente();
    
    $objCliente->setApellidoPaterno($apellidoPaterno);
    $objCliente->setApellidoMaterno($apellidoMaterno);
    $objCliente->setNombres($nombre);
    $objCliente->setDniCliente($codigo);
    $objCliente->setDireccionCliente($direccion);
    $objCliente->setTelefonoCiente($telefonoFijo);
    $objCliente->setCelularCliente($telefonoMovil);
    $objCliente->setEmailCliente($email);

    
    if ($tipoOperacion == "agregar"){
        $resultado = $objCliente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Agregado correctamente", "");
        }
    }else{
        $resultado = $objCliente->editar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Actualizado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
