<?php require_once 'sesion.validar.view.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Opciones de Menú</title>
        <?php require_once 'metas.view.php'; ?>
        <?php require_once 'estilos.view.php'; ?>
        <!--Autocompletado-->
        <link href="../util/lte/plugins/autocomplete/jquery.ui.css" rel="stylesheet"/>
        
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
            <form id="frmgrabar">
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1 class="text-bold" style="font-size: 28px;">Registrar comanda</h1>
                        <ol class="breadcrumb">
                            <button type="button" class="btn btn-info btn-sm" id="btnVerConsumo">Ver consumo de mesas</button>
                            <button type="submit" class="btn btn-success btn-sm">Registrar la comanda</button>
                        </ol>
                    </section>
                    <small>
                        <section class="content">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label>Nº Comanda</label>
                                                <input type="text" class="form-control input-sm" id="txtnrocom" name="txtnrocom" required="" readonly=""/>
                                            </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label>Fecha</label>
                                                <input type="date" class="form-control input-sm" id="txtfec" name="txtfec" required="" value="<?php echo date('Y-m-d'); ?>" readonly=""/>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="form-group">
                                                <label>Mesa</label>
                                                <select class="form-control input-sm" id="cbomesa" name="cbomesa">

                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /row -->
                                    <!-- /row -->
                                </div>
                            </div>


                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Digite las iniciales de un producto que desea buscar</label>
                                                <input type="text" class="form-control input-sm" id="txtproducto" />
                                                <input type="hidden" id="txtcodigoproducto" />
                                                <input type="hidden" id="txtcodusu" name="txtcodusu" value="<?php echo $codigoUsuarioSesion; ?>" />
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-1">
                                            <div class="form-group">
                                                <label>C.Stk</label>
                                                <input type="text" name="txtcontrolastock" class="form-control input-sm" id="txtcontrolastock" readonly="" />
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-1">
                                            <div class="form-group">
                                                <label>Stock</label>
                                                <input type="text" class="form-control input-sm" id="txtstock" readonly="" />
                                            </div>
                                        </div>
                                        <div class="col-xs-1">
                                            <div class="form-group">
                                                <label>Precio</label>
                                                <input type="text" name="txtprecio" class="form-control input-sm" id="txtprecio" readonly="" />
                                            </div>
                                        </div>
                                        <div class="col-xs-1">
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="text" name="txtcantidad" class="form-control input-sm" id="txtcantidad" />
                                            </div>
                                        </div>
                                        <div class="col-xs-1">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <br>
                                                <button type="button" class="btn btn-danger btn-sm" id="btnadicionar">Adicionar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <table id="tabla-listado" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>CÓDIGO</th>
                                                        <th>PRODUCTO</th>
                                                        <th style="text-align: right">PRECIO</th>
                                                        <th style="text-align: right">CANTIDAD</th>
                                                        <th style="text-align: right">IMPORTE</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="detalleventa">

                                                </tbody>



                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="row">
<!--                                        <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">SUB.TOTAL:</span>
                                                <input type="text" class="form-control text-right text-bold" id="txtimportesubtotal" name="txtimportesubtotal" readonly="" style="width: 100px; z-index: 0;" />
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">IGV:</span>
                                                <input type="text" class="form-control text-right text-bold" id="txtimporteigv" name="txtimporteigv" readonly="" style="width: 100px; z-index: 0;"/>
                                            </div>
                                        </div>-->
                                        <div class="col-xs-3">
                                            <div class="input-group">
                                                <span class="input-group-addon">NETO A PAGAR:</span>
                                                <input type="text" class="form-control text-right text-bold" id="txtimporteneto" name="txtimporteneto" readonly="" style="width: 100px; z-index: 0;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </small>
                </div>
            </form>
            <!-- /.content-wrapper -->
            <?php require_once 'pie.pagina.view.php'; ?>
            <!-- Control Sidebar -->
            <?php require_once 'menu.derecha.view.php'; ?>
            <!-- /.control-sidebar -->
        </div>
        <!-- ./wrapper -->
        <?php require_once 'scripts.view.php'; ?>

        <!-- Scripts de autocompletado -->
        <script src="../util/lte/plugins/autocomplete/jquery.ui.autocomplete.js" type="text/javascript"></script>
        <script src="../util/lte/plugins/autocomplete/jquery-ui.js" type="text/javascript"></script>
        <script src="js/producto.autocompletar.js" type="text/javascript"></script>
        
        <!-- Scripts de la página -->
        <script src="js/mesa.js" type="text/javascript"></script>
        <script src="js/restaurante.comanda.js" type="text/javascript"></script>
        
    </body>
</html>