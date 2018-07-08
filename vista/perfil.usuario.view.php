<?php require_once 'sesion.validar.view.php'; ?>

<?php
    //LLamar al controlador "leer.datos.perfil.usuario.controller.php"

    /*Crear la variable $_POST["codigo_usuario_sesion"]*/
    $_POST["codigo_usuario_sesion"] = $s_codigoUsuario;
    /*Crear la variable $_POST["codigo_usuario_sesion"]*/
            
    require_once '../controlador/leer.datos.perfil.usuario.controller.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Perfil de Usuario</title>
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
                        Perfil de Usuario
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Perfil de Usuario</a></li>
                        <!--<li class="active">Blank page</li>-->
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Datos del usuario</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Perfil del usuario</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Foto del usuario</a></li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form role="form" action="../controlador/actualizar.datos.perfil.usuario.controller.php" method="post">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Código Usuario</label>
                                                    <input type="text" name="txtCod" value="<?php echo $datosUsuarioBD["codigo_usuario"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Código Usuario" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">DNI</label>
                                                    <input type="text" name="txtDNI" value="<?php echo $datosUsuarioBD["dni"] ?>" class="form-control" id="exampleInputEmail1" placeholder="DNI" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Apellido Paterno</label>
                                                    <input type="text" name="txtApePat" value="<?php echo $datosUsuarioBD["apellido_paterno"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Apellido Paterno">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Apellido Materno</label>
                                                    <input type="text" name="txtApeMat" value="<?php echo $datosUsuarioBD["apellido_materno"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Apellido Materno">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nombres</label>
                                                    <input type="text" name="txtNom" value="<?php echo $datosUsuarioBD["nombres"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Nombres">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Dirección</label>
                                                    <input type="text" name="txtDir" value="<?php echo $datosUsuarioBD["direccion"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Dirección">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Correo Electrónico</label>
                                                    <input type="text" name="txtCorreo" value="<?php echo $datosUsuarioBD["email"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Correo Electrónico">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Teléfono Fijo</label>
                                                    <input type="text" name="txtTel1" value="<?php echo $datosUsuarioBD["telefono_fijo"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Teléfono Fijo">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Teléfono Móvil #1</label>
                                                    <input type="text" name="txtTel2" value="<?php echo $datosUsuarioBD["telefono_movil1"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Teléfono Móvil #1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Teléfono Móvil #2</label>
                                                    <input type="text" name="txtTel3" value="<?php echo $datosUsuarioBD["telefono_movil2"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Teléfono Móvil #2">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Cargo</label>
                                                    <input type="text" value="<?php echo $datosUsuarioBD["cargo"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Cargo" readonly="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Área</label>
                                                    <input type="text" value="<?php echo $datosUsuarioBD["area"] ?>" class="form-control" id="exampleInputEmail1" placeholder="Área" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Guardar mis datos</button>
                                    </div>
                                </form>
                            </div>
                                    <!-- /.box-body -->

                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                     <?php require_once './editor.texto.view.php'; ?>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_3">                                
                                    <?php require_once './subir.foto.view.php'; ?> 
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Guardar foto</button>
                                    </div>
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
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
    </body>
</html>