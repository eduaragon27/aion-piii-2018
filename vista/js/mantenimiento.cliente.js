//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    listar();
});

function listar(){
    $.post("../controlador/cliente.listar.controller.php").done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>DNI</th>';
            html += '<th>APELLIDO PATERNO</th>';
            html += '<th>APELLIDO MATERNO</th>';
            html += '<th>NOMBRES</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>TELEFONO</th>';
            html += '<th>CELULAR</th>';
            html += '<th>EMAIL</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.dni_cliente+'</td>';
                html += '<td>'+item.apellido_paterno+'</td>';
                html += '<td>'+item.apellido_materno+'</td>';
                html += '<td>'+item.nombres+'</td>';
                html += '<td>'+item.direccion_cliente+'</td>';
                html += '<td>'+item.telefono_cliente+'</td>';
                html += '<td>'+item.celular_cliente+'</td>';
                html += '<td>'+item.email_cliente+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.dni_cliente + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.dni_cliente + ')"><i class="fa fa-close"></i></button>';
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
    $("#titulomodal").html("Agregar nuevo Cliente");
    $("#txtTipoOperacion").val("agregar");
    $("#txtApellidoPaterno").val("");
    $("#txtApellidoMaterno").val("");
    $("#txtNombre").val("");
    $("#txtCodigo").val("");
    $("#txtDireccion").val("");
    $("#txtTelefonoFijo").val("");
    $("#txtTelefonoMovil1").val("");
    $("#txtEmail").val("");
});

$("#myModal").on("shown.bs.modal", function(){
    $("#txtApellidoPaterno").focus();
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
            var codigoCliente = $("#txtCodigo").val();
            var ape_pat = $("#txtApellidoPaterno").val();
            var ape_mat = $("#txtApellidoMaterno").val();
            var nombre = $("#txtNombre").val();
            var direccion = $("#txtDireccion").val();
            var telefonoFijo = $("#txtTelefonoFijo").val();
            var telefonoMovil1 = $("#txtTelefonoMovil1").val();
            var email = $("#txtEmail").val()
            
            
            //swal(codigoArticulo);
            //swal(nombre);
            
            $.post
                (
                    "../controlador/cliente.agregar.editar.controller.php",
                    {
                        p_cod: codigoCliente,
                        p_ape_pat: ape_pat,
                        p_ape_mat: ape_mat,
                        p_tipo_ope: tipoOperacion,
                        p_nom: nombre,
                        p_direccion: direccion,
                        p_tel_fij: telefonoFijo,
                        p_tel_mov: telefonoMovil1,
                        p_email: email
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


function leerDatos(codigo_cliente){
    $.post
        (
            "../controlador/cliente.leer.datos.controller.php",
            {
                p_cod: codigo_cliente
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.dni_cliente);
                $("#txtApellidoPaterno").val(datosJSON.datos.apellido_paterno);
                $("#txtApellidoMaterno").val(datosJSON.datos.apellido_materno);
                $("#txtNombre").val(datosJSON.datos.nombres);
                $("#txtDireccion").val(datosJSON.datos.direccion_cliente);
                $("#txtTelefonoFijo").val(datosJSON.datos.telefono_cliente);
                $("#txtTelefonoMovil1").val(datosJSON.datos.celular_cliente);
                $("#txtEmail").val(datosJSON.datos.email_cliente);
                $("#titulomodal").html("Editar cliente");
                
            
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}

function eliminar(codigo_cliente){
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
                    "../controlador/cliente.eliminar.controller.php",
                    {
                        p_cod: codigo_cliente
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

   
