<?php

session_name("programacionII");
session_start();

/*Limpiar cada variable cargada en la sesión*/
unset($_SESSION["nombre_usuario"]);
unset($_SESSION["email_usuario"]);
unset($_SESSION["codigo_cargo"]);
unset($_SESSION["dni_usuario"]);
session_destroy();

//header("location:../vista/index.html");

require_once '../util/funciones/Funciones.clase.php';
Funciones::mensaje("Se ha cerrado la sesión correctamente", "s", "../vista/index.html", 5);