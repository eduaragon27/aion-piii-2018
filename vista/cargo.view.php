<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Listado de Cargos</title>
    </head>
    <body>
        <?php
            
            require_once '../controlador/cargo.listar.controller.php';
            
            echo '<pre>';
            print_r($resultado);
            echo '</pre>';
            
            
        ?>    
        
    </body>
</html>
