//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    listar();
});

function listar(){
    $.post("../controlador/mesa.listado.listar.controller.php").done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>MESA</th>';
            html += '<th>DESCRIPCION</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_mesa+'</td>';
                html += '<td>'+item.mesa+'</td>';
                html += '<td>'+item.descripcion+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_mesa + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_mesa + ')"><i class="fa fa-close"></i></button>';
		html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';
            
            $("#listado").html(html);
            
            $('#tabla-listado').dataTable({
                "aaSorting": [[0, "asc"]]
            });
            
        }else{
            
        }
    })
    
    
}

$("#btnagregar").click(function(){
    $("#titulomodal").html("Agregar nueva opción de menú");
    $("#txtTipoOperacion").val("agregar");
    $("#txtCodigo").val("");
    $("#txtmesa").val
    $("#txtdescripcion").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtNombre").focus();
});



$("#frmgrabar").submit(function(event){
    event.preventDefault();
    
    swal({
            title: "Confirme",
            text: "¿Esta seguro de grabar los datos ingresados?",
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
            
            var codigoMesa = "";
            
            if (tipoOperacion === "agregar"){
                codigoMesa = "nuevo";
            }else{
                codigoMesa = $("#txtCodigo").val();
            }
            
            var mesa = $("#txtMesa").val();
            var descripcion = $("#txtDescripcion").val();   
            var estado = "D"
            //swal(codigoMesa);
            //swal(nombre);
            
            $.post
                (
                    "../controlador/mesa.agregar.editar.controller.php",
                    {
                        p_mesa: mesa,
                        p_descripcion: descripcion,
                        p_tipo_ope: tipoOperacion,
                        p_cod: codigoMesa,
                        p_estado: estado
                    }
                ).done(function(resultado){
                    var datosJSON = resultado;
                    
                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
                        $("#btncerrar").click(); //Cerrar la ventana 
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
    
});


function leerDatos(codigo_mesa){
    $.post
        (
            "../controlador/mesa.leer.datos.controller.php",
            {
                p_cod: codigo_mesa
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_mesa);
                $("#txtMesa").val(datosJSON.datos.mesa);
                $("#txtDescripcion").val(datosJSON.datos.descripcion);
                $("#titulomodal").html("Editar opción de menú");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}

function eliminar(codigo_mesa){
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
                    "../controlador/mesa.eliminar.controller.php",
                    {
                        p_cod: codigo_mesa
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

   
