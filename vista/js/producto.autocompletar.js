/*INICIO: BUSQUEDA DE CLIENTES*/
$("#txtproducto").autocomplete({
    source: "../controlador/producto.autocompletar.controller.php",
    minLength: 4, //Filtrar desde que colocamos 5 o mas caracteres
    focus: f_enfocar_registro,
    select: f_seleccionar_registro
});

function f_enfocar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtproducto").val(registro.nombre);
    event.preventDefault();
}

function f_seleccionar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtproducto").val(registro.nombre);
    $("#txtcodigoproducto").val(registro.codigo);
    $("#txtstock").val(registro.stock);
    $("#txtprecio").val(registro.precio);
    $("#txtcontrolastock").val(registro.controla_stock);
//    $("#txtpresentacion").val(registro.presentacion);
    
//    cargarComboUnidadMedida("#cbounidad", "seleccione", registro.codigo);
    
    event.preventDefault();
}

/*FIN: BUSQUEDA DE CLIENTES*/


