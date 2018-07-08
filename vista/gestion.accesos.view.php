<?php require_once 'sesion.validar.view.php'; ?>
<?php require_once '../controlador/menuitemaccesos.listar.controller.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Opciones de Menú</title>
        <?php require_once 'metas.view.php'; ?>
        <?php require_once 'estilos.view.php'; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!--Llamar a la cabecera de la página -->
            <?php require_once 'menu.cabecera.view.php'; ?>
            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <?php require_once 'menu.izquierda.view.php'; ?>
            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Gestion de accesos y permisos
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <!--<li><a href="#">Examples</a></li>
                        <li class="active">Blank page</li>-->
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="box box-primary">   
                        <form role="form">
                            <div class="box-body">     
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Cargo de usuario</label>
                                                <select name="cboCargo" id="cboCargo" class="form-control input-sm">  
                                                </select>                                  
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Menú</label>
                                                <select name="cboMenu" id="cboMenu" class="form-control input-sm">  
                                                </select>                                  
                                        </div>
                                    </div>
                                </div>
                               <div class="row">
<!--                                Listar y ver si las mesas estan disponibles, ocupadas o reservadas-->
                                <?php for ($i =0; $i < count($listaConsumoMesas ); $i++){?>
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="info-box">
                                            <?php
                                                $color ="";
                                                switch ($listaConsumoMesas[$i]["estado"]) {
                                                    case "D":
                                                        $color = "bg-green";
                                                        break;
                                                    case "O":
                                                        $color = "bg-red";
                                                        break;
                                                    case "R":
                                                        $color = "bg-yellow";
                                                        break;
                                                    
                                                }           
                                            ?>
                                            
                                            <?php  if($listaConsumoMesas[$i]["estado"]=="O"){ ?>                                            
                                            <a href="#" data-toggle="modal" data-target ="#myModal"> <span class="info-box-icon <?php echo $color ?>"><i class="fa fa-cutlery"></i></span></a>
                                            <?php }else { ?>
                                            <span class="info-box-icon <?php echo $color ?>"><i class="fa fa-cutlery"></i></span>
                                            <?php }?>
                                            <div class="info-box-content">
                                                <span class="info-box-number"><?php echo $listaConsumoMesas[$i]["mesa"]?></span>
                                                <span class="info-box-text"> 
                                                    <?php 
                                                        if($listaConsumoMesas[$i]["pedidos"]>0){
                                                            echo "Pedidos: " . $listaConsumoMesas[$i]["pedidos"];
                                                            echo '<br>';
                                                            echo "Consumo S/: " . $listaConsumoMesas[$i]["consumo"];
                                                        }
                                                    ?>
                                                   <!-- TAREA: HACER QUE MUESTRE LAS RESERVAS, EL NOMBRE DE QUIEN LA RESERVA Y EL NUMERO DE PERSONAS QUE VAN A LLEGAR-->
                                                </span>
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                    <!-- /.col -->
                                <?php }?>  
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked>
                                            <label class="onoffswitch-label" for="myonoffswitch">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                            </div>
                            <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php require_once 'pie.pagina.view.php'; ?>
            <!-- Control Sidebar -->
            <?php require_once 'menu.derecha.view.php'; ?>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <?php require_once 'scripts.view.php'; ?>
        
        <!-- Scripts de la página -->
        <script src="js/cargo.js" type="text/javascript"></script>
        <script src="js/mantenimiento.accesos.js" type="text/javascript"></script>
    </body>
</html>