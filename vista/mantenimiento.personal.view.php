<?php require_once 'sesion.validar.view.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Personal/Usuarios</title>
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
                        Mantenimiento de personal/usuarios
                    </h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Agregar un nuevo personal/usuario</button>&nbsp;&nbsp;&nbsp;
                        <li><a href="#"><i class="fa fa-dashboard"></i> Menú Principal</a></li>
                        <li><a href="#">Administracion del sistema</a></li>
                        <li class="active">Mantenimiento de Personal/Usuarios</li>-->
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body">
                                    <div id="listado"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INICIO del formulario modal -->
                    <small>
                        <form id="frmgrabar">
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                  </div>
                                  <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <p>
                                                    <input type="hidden" value="" id="txtTipoOperacion" name="txtTipoOperacion">
                                                    Código <input type="text" 
                                                                  name="txtCodigo" 
                                                                  id="txtCodigo" 
                                                                  class="form-control input-sm text-bold" 
                                                                  readonly="">
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Apellido Paterno <input type="text" 
                                                                  name="txtApellidoPaterno" 
                                                                  id="txtApellidoPaterno" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Apellido Materno <input type="text" 
                                                                  name="txtApellidoMaterno" 
                                                                  id="txtApellidoMaterno" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                      
                                      <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Nombre <input type="text" 
                                                                  name="txtNombre" 
                                                                  id="txtNombre" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                      
                                      <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Dni <input type="text" 
                                                                  name="txtDni" 
                                                                  id="txtDni" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                                                        
                                      
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Email <input type="text" 
                                                                  name="txtEmail" 
                                                                  id="txtEmail" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Clave <input  type="password" 
                                                                  name="txtClave" 
                                                                  id="txtClave" 
                                                                  class="form-control input-sm text-bold">
                                                </p>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Cargo
                                                        <select name="cboCargo" id="cboCargo" class="form-control input-sm">  
                                                        </select>   
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Área
                                                        <select name="cboArea" id="cboArea" class="form-control input-sm">  
                                                        </select>   
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Estado
                                                        <select name="cboEstado" id="cboEstado" class="form-control input-sm">  
                                                        </select>   
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                   Jefe
                                                        <select name="cboJefe" id="cboJefe" class="form-control input-sm">  
                                                        </select>   
                                                </p>
                                            </div>
                                        </div>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </form>
                    </small>
                    <!-- FIN del formulario modal -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <?php require_once 'pie.pagina.view.php'; ?>

            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <?php require_once 'scripts.view.php'; ?>
        
        <!-- Scripts de la página -->
        <script src="js/estado.js" type="text/javascript"></script>
        <script src="js/jefe.js" type="text/javascript"></script>
        <script src="js/cargo.js" type="text/javascript"></script>
        <script src="js/area.js" type="text/javascript"></script>
        <script src="js/mantenimiento.personal.js" type="text/javascript"></script>
    </body>
</html>