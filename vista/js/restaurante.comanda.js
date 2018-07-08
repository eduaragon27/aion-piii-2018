$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
    cargarComboMesaComanda("#cbomesa", "seleccione");   
});
$("#btnadicionar").click(function(){
    if ($("#txtcodigoproducto").val().toString() === ""){
        $("#txtproducto").focus();
        swal("Verifique", "Debe seleccionar un producto", "warning");
        return 0; //detiene el programa
    }
    
    
    //capturar los varlores en variables para luego agregar a la tabla html
    var codigoProd      = $("#txtcodigoproducto").val();
    var nombreProd      = $("#txtproducto").val();
    var precioVenta     = $("#txtprecio").val();
    var cantidadVenta   = $("#txtcantidad").val();
    
    if (cantidadVenta === ""){
        $("#txtcantidad").focus();
        swal("Verifique", "Ingrese la cantidad a vender", "warning");
        return 0; //detiene el programa
    }

    
    var importe   = precioVenta * cantidadVenta;
    
    //Elaborar una variable con el HTML para agregar al detalle
    var fila = '<tr>'+
                    '<td class="text-center">' + codigoProd + '</td>' +
                    '<td>' + nombreProd + '</td>' +
                    '<td class="text-right">' + parseFloat(precioVenta).toFixed(2) + '</td>' +
                    '<td class="text-right">' + cantidadVenta + '</td>' +
                    '<td class="text-right">' + parseFloat(importe).toFixed(2) + '</td>' +
                    '<td id="col_eliminar" class="text-center"><a href="#"> <i style="font-size:20px;" class="fa fa-close text-danger"></i> </a></td>' +
                '</tr>';
        
        
    //Agregar el registro al detalle de la venta
    $("#detalleventa").append(fila);
    calcularTotales();
   
    //Limpiar las cajas de texto
    $("#txtcodigoproducto").val("");
    $("#txtproducto").val("");
    $("#txtprecio").val("");
    $("#txtcantidad").val("");
    $("#txtstock").val("");
    $("#txtcontrolastock").val("");
    $("#txtproducto").focus();
    
    
});

$("#txtcantidad").keypress(function(evento){
    if (evento.which === 13){ //13 es el valor de la tecla Enter
        evento.preventDefault(); //Evita que la página recargue
        $("#btnadicionar").click();
    }
});

function calcularTotales(){
    var neto = 0;
    $("#detalleventa tr").each(function(){
        var importe = $(this).find("td").eq(4).html(); //Leer el valor que esta en la columna 4 (Importe)
        neto = neto + parseFloat(importe);
    });
    
    $("#txtimporteneto").val(neto.toFixed(2));
    
    }
$(document).on("click", "#col_eliminar", function(){
    
    var filaEliminar = $(this).parents().get(0); //Capturar la fila que se desea eliminar
    
    swal({
		title: "Confirme",
		text: "¿Desea eliminar el registro seleccionado?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: '#ff0000',
		confirmButtonText: 'Si',
		cancelButtonText: "No",
		closeOnConfirm: true,
		closeOnCancel: true
	},
	function(isConfirm){ 
            if (isConfirm){ //el usuario hizo clic en el boton SI     
                filaEliminar.remove(); //Elimina la fila seleccionada
                calcularTotales();
                $("#txtproducto").focus();
            }
	});   
});

//Inicio de grabar:

var arrayDetalle = new Array(); //permite almacenar todos los productos agregados en el detalle de la venta

$("#frmgrabar").submit(function(evento){
    evento.preventDefault(); //Descarta el evento submit que el formulario tiene por default
    
    swal({
        title: "Confirme",
        text: "¿Esta seguro de grabar los datos de la venta?",
        showCancelButton: true,
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../images/pregunta.png"
    },
    function(isConfirm){ 

        if (isConfirm){ //el usuario hizo clic en el boton SI     
            //procedo a grabar   
            
            /*Limpiar el array*/
            arrayDetalle.splice(0, arrayDetalle.length);
            /*RECORREMOS CADA FILA DE LA TABLA DONDE ESTAN LOS PRODUCTOS DE LA COMANDA*/
            $("#detalleventa tr").each(function(){
                var codigo_producto  = $(this).find("td").eq(0).html();
                var precio_venta     = $(this).find("td").eq(2).html();
                var cantidad         = $(this).find("td").eq(3).html();
                var importe          = $(this).find("td").eq(4).html();
                
                var objDetalle = new Object();
                objDetalle.codigo_producto  = codigo_producto;
                objDetalle.precio_venta     = precio_venta;
                objDetalle.cantidad         = cantidad;
                objDetalle.importe          = importe;
                
                arrayDetalle.push(objDetalle);//Almacena el arrayDetalle de cada Objeto ""
            });
            
            /*Convertir el arayDetalle a formato JSON*/
            var jsonDetalle = JSON.stringify(arrayDetalle);
           
//            alert(jsonDetalle);
            $.post
                (
                    "../controlador/comanda.registrar.controller.php",
                    {
                        p_fecha_comanda: $("#txtfec").val(),
                        p_codigo_mesa: $("#cbomesa").val(),
                        p_codigo_usuario: 1 ,//colocar el codigo del usuario en el campo oculto
                        p_detalle_comanda: jsonDetalle
                    }
                ).done(function(resultado){
                    var datosJSON = resultado;
                    
                    if (datosJSON.estado === 200){
                        swal("Exito", datosJSON.mensaje, "success");
//                        document.location.href=""
                        setTimeout(location.reload(0),3000);
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

$("#btnVerConsumo").click(function(){
    document.location.href = "consumo.mesas.view.php";  
});
