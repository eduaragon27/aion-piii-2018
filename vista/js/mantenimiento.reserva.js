//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
});

function leerCodigoMesa(codigoMesa){
 $("#txtMesa").val(codigoMesa);
 $("#titulomodalreserva").html("Registro de nueva reserva");
 $("#txtTipoOperacion").val("agregar");
 $("#txtCliente").val("");
 $("#txtCodigoReserva").val("")
}

$("#modalreserva").on("shown.bs.modal", function(){
    $("#txtCliente").focus();
});

$("#frmgrabar").submit(function(event){
    event.preventDefault();
    
    swal({
            title: "Confirme",
            text: "¿Esta seguro de realizar la reserva?",
            showCancelButton: true,
            confirmButtonColor: '#3d9205',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../images/preguntar.png"
    },
    function(isConfirm){ 
        if (isConfirm){ //el usuario hizo clic en el boton SI     
            //swal("Mensaje", "El usuario hizo clic en SI", "success");
            
            var tipoOperacion = $("#txtTipoOperacion").val();
            //swal("Tipo de Operación: " + tipoOperacion);
            
            var codigoReserva = "";
            
            if (tipoOperacion === "agregar"){
                codigoReserva = "nuevo";
            }else{
                codigoReserva = $("#txtCodigoReserva").val();
            }
            
            var cliente= $("#txtCliente").val();
            var mesa= $("#txtMesa").val();

            //swal(codigoReserva);
            //swal(descripcion);
            
            $.post
                (
                    "../controlador/reserva.agregar.editar.controller.php",
                    {
                        p_cliente: cliente,
                        p_tipo_ope: tipoOperacion,
                        p_cod_mesa: mesa,
                        p_cod_reserva: codigoReserva
                    }
                ).done(function(resultado){
                    var datosJSON = resultado;
                    
                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        $("#btncerrarmodal").click(); //Cerrar la ventana 
                         location.reload();
                    }else{
                      swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                   var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
        }
    });
    
});


function leerDatos(codigo_mesa){
    $.post
        (
            "../controlador/reserva.listar.controller.php",
            {
                p_cod_mesa: codigo_mesa
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
            var html = "";
            //Detalle
            $.each(datosJSON.datos, function(i,item) {

                html += '<a>'+item.mesa+'</a>';
                html += '<a>'+item.cliente+'</a>';

            });
      
            $("#detallereserva").html(html);
            
//            $('#tabla-listado').dataTable({
//                "aaSorting": [[0, "asc"]]
//            });
            $("#titulomodalinfo").html("Detalle de reserva");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}
function eliminar(codigo_reserva){
    swal({
            title: "Confirme",
            text: "¿Esta seguro de eliminar el registro?",
            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../images/eliminar2.png"
    },
    function(isConfirm){ 
        if (isConfirm){
            $.post
                (
                    "../controlador/reserva.eliminar.controller.php",
                    {
                        p_cod: codigo_reserva
                    }
                ).done(function(resultado){
                    var datosJSON = resultado;

                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        listar(); //actualizar la lista

                    }else{
                      swal("Mensaje del sistema", resultado , "warning");
                    }
                }).fail(function(error){
                   var datosJSON = $.parseJSON( error.responseText );
                   swal("Ocurrió un error", datosJSON.mensaje , "error");
                });
        }
    });
}

   
