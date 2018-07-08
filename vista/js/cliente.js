function cargarComboCliente(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/cliente.cargar.combo.controller.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Cliente</option>';
            }else{
                html += '<option value="0">Todos los Clientes</option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_cliente+'">'+item.apellido_paterno+'  '+item.apellido_materno+'  '+item.nombres+'</option>';
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