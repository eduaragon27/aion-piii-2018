//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    cargarComboEstado("#cboEstado", "seleccione");
    cargarComboCargo("#cboCargo", "seleccione");
    cargarComboArea("#cboArea", "seleccione");
    cargarComboJefe("#cboJefe", "seleccione");
    listar();
});

function listar(){
    $.post("../controlador/personal.listar.controller.php").done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>DNI</th>';
            html += '<th>NOMBRES Y APELLIDOS</th>';
            html += '<th>E-MAIL</th>';
            html += '<th>CARGO</th>';
            html += '<th>AREA</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_usuario+'</td>';
                html += '<td>'+item.dni_usuario+'</td>';
                html += '<td>'+item.nombre+'</td>';
                html += '<td>'+item.email+'</td>';
                html += '<td>'+item.cargo+'</td>';
                html += '<td>'+item.area+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_usuario + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' +item.codigo_usuario+ ', ' +item.dni_usuario+ ')"><i class="fa fa-close"></i></button>';
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
    $("#titulomodal").html("Agregar nuevo Personal");
    $("#txtTipoOperacion").val("agregar");
    $("#txtCodigo").val("");
    $("#txtApellidoPaterno").val("");
    $("#txtApellidoMaterno").val("");
    $("#txtNombre").val("");
    $("#txtDni").val("");
    $("#cboEstado").val("");
    $("#cboCargo").val("");
    $("#cboArea").val("");
    $("#cboJefe").val("");
    $("#txtClave").val("");
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
            var codigoPersonal = "";
            
            if (tipoOperacion === "agregar"){
                codigoPersonal = "nuevo";
            }else{
                codigoPersonal = $("#txtCodigo").val();
            }
            
            var ape_pat = $("#txtApellidoPaterno").val();
            var ape_mat = $("#txtApellidoMaterno").val();
            var nombre = $("#txtNombre").val();
            var dni = $("#txtDni").val();
            var estado = $("#cboEstado").val();
            var cargo = $("#cboCargo").val();
            var area = $("#cboArea").val();
            var jefe = $("#cboJefe").val();
            var email = $("#txtEmail").val();
            var clave = $("#txtClave").val()
            
            
            //swal(codigoArticulo);
            //swal(nombre);
            
            $.post
                (
                    "../controlador/personal.agregar.editar.controller.php",
                    {
                        p_cod: codigoPersonal,
                        p_ape_pat: ape_pat,
                        p_ape_mat: ape_mat,
                        p_tipo_ope: tipoOperacion,
                        p_nom: nombre,
                        p_dni: dni,
                        p_estado: estado,
                        p_cargo: cargo,
                        p_area: area,
                        p_dni_jefe: jefe,
                        p_email: email,
                        p_clave: clave
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


function leerDatos(codigo_personal){
    $.post
        (
            "../controlador/personal.leer.datos.controller.php",
            {
                p_cod: codigo_personal
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_usuario);
                $("#txtApellidoPaterno").val(datosJSON.datos.apellido_paterno);
                $("#txtApellidoMaterno").val(datosJSON.datos.apellido_materno);
                $("#txtNombre").val(datosJSON.datos.nombres);
                $("#txtDni").val(datosJSON.datos.dni_usuario);
                $("#cboEstado").val(datosJSON.datos.estado);
                $("#cboCargo").val(datosJSON.datos.codigo_cargo);
                $("#cboArea").val(datosJSON.datos.codigo_area);
                $("#cboJefe").val(datosJSON.datos.dni_jefe);
                $("#txtClave").val(datosJSON.datos.clave);
                $("#txtEmail").val(datosJSON.datos.email);
                $("#titulomodal").html("Editar personal");
           
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}

function eliminar(dni, codigo_personal){
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
                    "../controlador/personal.eliminar.controller.php",
                    {
                        p_dni: dni,
                        p_cod: codigo_personal
                        
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

   
