<?php require_once 'sesion.validar.view.php'; ?>
<?php require_once '../controlador/mesa.consumo.controller.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Opciones de Menú</title>
        <?php require_once 'metas.view.php'; ?>
        <?php require_once 'estilos.view.php'; ?>
        <!--Autocompletado-->
       
        
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
                        <h1 class="text-bold" style="font-size: 28px;">Consumo de mesas</h1>        
                    </section>
                    <small>
                        <section class="content">
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
                                            <a href="#" onclick="leerNumeroComanda(<?php echo $listaConsumoMesas[$i]["numero_comanda"]?>)" data-toggle="modal" data-target ="#myModal"><span class="info-box-icon <?php echo $color ?>"><i class="fa fa-cutlery" id="tbcomandadetalle"></i></span></a>                                          
                                            <?php }else { if($listaConsumoMesas[$i]["estado"]=="D"){?>
                                            <a href="#" onclick="leerCodigoMesa(<?php echo $listaConsumoMesas[$i]["codigo_mesa"]?>)" data-toggle="modal" data-target ="#modalreserva"><span class="info-box-icon <?php echo $color ?>"><i class="fa fa-cutlery" id="tbcomandadetalle"></i></span></a>                                           
                                            <?php }else {?>
                                            <a href="#" onclick="leerDatos(<?php echo $listaConsumoMesas[$i]["codigo_mesa"]?>)" data-toggle="modal" data-target ="#modalinfo"><span class="info-box-icon <?php echo $color ?>"><i class="fa fa-cutlery"></i></span></a>  
                                            <?php }}?>
                                            <div class="info-box-content">
                                                <span class="info-box-number"><?php echo $listaConsumoMesas[$i]["mesa"]?></span>
                                                <span class="info-box-text"> 
                                                
                                                    <?php 
                                                        if($listaConsumoMesas[$i]["pedidos"]>0){
                                                            echo "Pedidos: " . $listaConsumoMesas[$i]["pedidos"];
                                                            echo '<br>';
                                                            echo "Consumo S/: " . $listaConsumoMesas[$i]["consumo"];
                                                            echo '<input type="hidden" value="'. $listaConsumoMesas[$i]["numero_comanda"];
                                                            echo '" id="txtNumeroComanda" name="txtNumeroComanda">';
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
                            </div>
                            <!-- /.row -->
                            <!-- INICIO del formulario modal -->
                             <form id="frmgrabar1">
                                    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                          </div>
                                          <div class="modal-body">
                                              <div class="row">
                                                    <div class="col-xs-12">
<!--                                                        <input type="hidden" value="" id="txtNumeroComanda" name="txtNumeroComanda">-->
                                                        <table id="tabla-listado" class="table table-bordered table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th>PRODUCTO </th>
                                                                    <th style="text-align: right">PRECIO</th>
                                                                    <th style="text-align: right">CANTIDAD</th>
                                                                    <th style="text-align: right">IMPORTE</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody id="detallecomanda">

                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <div class="pull-right">
<!--                                                        <div class="input-group">-->
                                                            <input type="text" class="form-control text-right text-bold" id="txtimporteneto" name="txtimporteneto" readonly="" style="width: 100px; z-index: 0;"/>
<!--                                                        </div>-->
                                                        </div>
                                                        
                                                        <div class="pull-left">
<!--                                                        <div class="input-group">-->
                                                            <button type="button" class="btn btn-danger btn-sm" id="btnfacturar">Facturar Consumo</button>
<!--                                                        </div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                          </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </form>
                            <!-- FIN del formulario modal -->   
                            <!-- INICIO del formulario modal -->
                                <form id="frmgrabar">
                                    <div class="modal fade" id="modalreserva" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodalreserva">Título de la ventana</h4>
                                          </div>
                                  <div class="modal-body">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <p>
                                                    <input type="hidden" value="" id="txtTipoOperacion" name="txtTipoOperacion">
                                                Código de reserva <input type="text" 
                                                                  name="txtCodigoReserva" 
                                                                  id="txtCodigoReserva" 
                                                                  class="form-control input-sm text-bold" 
                                                                  readonly="">
                                                </p>
                                            </div>                                           
                                        </div>
                                      
                                        <div class="row">
                                            <div class="col-xs-3">                                             
                                                    Mesa a reservar<input type="text" 
                                                                  name="txtMesa" 
                                                                  id="txtMesa" 
                                                                  class="form-control input-sm text-bold" 
                                                                  readonly="">
                                                </p>
                                            </div>                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p>
                                                    Cliente que reservará la mesa<input type="text" 
                                                                  name="txtCliente" 
                                                                  id="txtCliente" 
                                                                  class="form-control input-sm text-bold">
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
                            <!-- FIN del formulario modal --> 
                            
                            <!-- INICIO del formulario modal -->
                                <form id="frmgrabar2">
                                    <div class="modal fade" id="modalinfo" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodalinfo">Título de la ventana</h4>
                                          </div>
                                  <div class="modal-body">
                                      <table id="tabla-listado" class="table table-bordered table-striped">

                                        <tbody id="detallereserva">

                                        </tbody>

                                     </table>
                                  </div>
                                  <div class="modal-footer">
                                      <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Aceptar</button>
                                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </form>
                            <!-- FIN del formulario modal --> 
                           
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

        <!-- Scripts de la página -->
        <script src="js/factura.comanda.js" type="text/javascript"></script>
        <script src="js/mantenimiento.reserva.js" type="text/javascript"></script>
    </body>
</html>