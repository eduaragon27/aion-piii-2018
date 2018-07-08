//jQuery
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    cargarComboCategoria("#cboCategoria", "seleccione"); 
    cargarComboMarca("#cboMarca", "seleccione"); 
//    habilitarcampostock();
    listar(); 
   
});

function listar(){
    $.post("../controlador/producto.listar.controller.php").done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>CODIGO</th>';
            html += '<th>NOMBRE DEL PRODUCTO</th>';
            html += '<th>DESCRIPCIÓN</th>';
            html += '<th>COLOR</th>';
            html += '<th>PRECIO</th>';
            html += '<th>CATEGORIA</th>';
            html += '<th>STOCK</th>';
	    html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td align="center">'+item.codigo_producto+'</td>';
                html += '<td>'+item.nombre_producto+'</td>';
                html += '<td>'+item.descripcion_producto+'</td>';
                html += '<td>'+item.color+'</td>';
                html += '<td>'+'S/ '+item.precio+'</td>';
                html += '<td>'+item.categoria+'</td>';
                html += '<td>'+item.stock+'</td>';
		html += '<td align="center">';
		html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_producto + ')"><i class="fa fa-pencil"></i></button>';
		html += '&nbsp;&nbsp;';
		html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_producto + ')"><i class="fa fa-close"></i></button>';
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
    $("#titulomodal").html("Agregar nuevo Producto");
    $("#txtTipoOperacion").val("agregar");
    $("#txtCodigo").val("");
    $("#txtNombre").val("");
    $("#txtDescripcion").val("");
    $("#txtPrecio").val("");
    $("#txtColor").val("");
    $("#txtStock").val("0");
    $("#cboEstado").val("A");
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
            var codigoProducto = "";
            
            if (tipoOperacion === "agregar"){
                codigoProducto = "nuevo";
            }else{
                codigoProducto = $("#txtCodigo").val();
            }
            
            
            var nombre = $("#txtNombre").val();
            var descripcion = $("#txtDescripcion").val();
            var precio = $("#txtPrecio").val();
            var codigoCategoria = $("#cboCategoria").val();
            var codigoMarca = $("#cboMarca").val();
            var stock = $("#txtStock").val() + " ";
            var estado = $("#cboEstado").val();
            var color = $("#txtColor").val();
            
            
            //swal(codigoProducto);
            //swal(nombre);
            
            $.post
                (
                    "../controlador/producto.agregar.editar.controller.php",
                    {

                        p_nom: nombre,
                        p_descrip: descripcion,
                        p_tipo_ope: tipoOperacion,
                        p_precio: precio,
                        p_cod_cat: codigoCategoria,
                        p_cod_marca: codigoMarca,
                        p_estado: estado,
                        p_stock: stock,
                        p_color: color,
                        p_cod: codigoProducto
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


function leerDatos(codigo_producto){
    $.post
        (
            "../controlador/producto.leer.datos.controller.php",
            {
                p_cod: codigo_producto
            }
        ).done(function(resultado){
            var datosJSON = resultado;

            if (datosJSON.estado === 200){
                $("#txtTipoOperacion").val("editar");
                $("#txtCodigo").val(datosJSON.datos.codigo_producto);
                $("#txtNombre").val(datosJSON.datos.nombre_producto);
                $("#txtDescripcion").val(datosJSON.datos.descripcion_producto);
                $("#cboCategoria").val(datosJSON.datos.codigo_categoria);
                $("#cboMarca").val(datosJSON.datos.codigo_marca)
                $("#txtPrecio").val(datosJSON.datos.precio);
                $("#txtStock").val(datosJSON.datos.stock);
                $("#txtColor").val(datosJSON.datos.color);
                $("#titulomodal").html("Editar artículo");
                
            }else{
              swal("Mensaje del sistema", resultado , "warning");
            }
        }).fail(function(error){
           var datosJSON = $.parseJSON( error.responseText );
           swal("Ocurrió un error", datosJSON.mensaje , "error");
        });
}

function eliminar(codigo_producto){
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
                    "../controlador/producto.eliminar.controller.php",
                    {
                        p_cod: codigo_producto
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
function cargarComboCategoria(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/categoria.listar.controller.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una categoria</option>';
            }else{
                html += '<option value="0">Todas las categorias</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_categoria+'">'+item.nombre_categoria+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}

function cargarComboMarca(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/marca.listar.controller.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una marca</option>';
            }else{
                html += '<option value="0">Todos las marcas</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_marca+'">'+item.nombre_marca+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}


   
