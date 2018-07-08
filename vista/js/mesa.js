function cargarComboMesaComanda(p_nombreCombo, p_tipo){
    $.post
    (
	"../controlador/mesa.listar.controller.php"
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una mesa</option>';
            }else{
                html += '<option value="0">Todas las mesas/option>';
            }

            
            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.codigo_mesa+'">'+item.mesa+ "&nbsp;&nbsp;&nbsp; " + item.consumo +'</option>';
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