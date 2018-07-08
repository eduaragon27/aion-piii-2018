//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    cargarComboMenu("#cboMenu", "seleccione");
    listar();
});

$("#btnlistar").click(function(){
listar();
});

function listar(){
    var cod_menu = $("#cboMenu").val();
    $.post("../controlador/item.listar.controller.php", 
            {           
                        p_cod_men: cod_menu
            }
            ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>NOMBRE DEL SUB-MENU</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_menu_item+'</td>';
                html += '<td>'+item.nombre+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_menu + ', ' + item.codigo_menu_item + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_menu + ', ' + item.codigo_menu_item + ')"><i class="fa fa-close"></i></button>';
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
    }).fail(function(error){
           swal('Seleccione un menu en el combo','','warning');
           $("#cboMenu").focus();
        });
    
    
}

$("#btnagregar").click(function(){
    $("#titulomodal").html("Agregar un nuevo sub menú");
    $("#txtTipoOperacion").val("agregar");
    $("#txtCodigoMenu").val("");
    $("#txtCodigoItem").val("");
    $("#txtNombre").val("");
    $("#txtArchivo").val("");
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
            
            var codigoMenu = "";
            var codigoItem = "";
            
            if (tipoOperacion === "agregar"){
                codigoMenu = $("#cboMenu").val();
                codigoItem = "nuevo";
            }else{
                codigoMenu = $("#cboMenu").val();
                codigoItem = $("#txtCodigoItem").val();
            }
            
            var nombre = $("#txtNombre").val();
            
            var archivo = $("#txtArchivo").val();
            
            //swal(codigoMenu);
            //swal(nombre);
            
            $.post
                (
                    "../controlador/item.agregar.editar.controller.php",
                    {
                        p_nom: nombre,
                        p_tipo_ope: tipoOperacion,
                        p_cod_men: codigoMenu,
                        p_cod_item: codigoItem,
                        p_archivo: archivo
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


function leerDatos(codigo_menu, codigo_item){
    $.post
        (
            "../controlador/item.leer.datos.controller.php",
            {
                p_cod_men: codigo_menu,
                p_cod_item: codigo_item
                
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigoMenu").val(datosJSON.datos.codigo_menu);
                $("#txtCodigoItem").val(datosJSON.datos.codigo_menu_item);
                $("#txtNombre").val(datosJSON.datos.nombre);
                $("#txtArchivo").val(datosJSON.datos.archivo);
                $("#titulomodal").html("Editar sub menú");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}

function eliminar(codigo_menu, codigo_item){
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
                    "../controlador/item.eliminar.controller.php",
                    {
                        p_cod_men: codigo_menu,
                        p_cod_item: codigo_item
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