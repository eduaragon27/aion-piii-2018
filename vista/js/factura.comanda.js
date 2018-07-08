
$(document).ready(function(){
    //alert("Se esta ejecutando código JavaScript utilizando JQuery");
//    listar()
});

function leerNumeroComanda(numeroComanda){
//    var num_com = $("#txtNumeroComanda").val();
    $.post("../controlador/comanda.detalle.listar.controller.php", 
            {           
                        p_num_com: numeroComanda
            }
            ).done(function(resultado){
        var datosJSON = resultado;
        if (datosJSON.estado === 200){ //OK
            var html = "";
            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                html += '<tr>';
                html += '<td>'+item.producto+'</td>';
                html += '<td>'+'S/ '+item.precio+'</td>';
                html += '<td>'+item.cantidad+'</td>';
                html += '<td>'+item.importe+'</td>';
                html += '</tr>';
            });
      
            $("#detallecomanda").html(html);
            
//            $('#tabla-listado').dataTable({
//                "aaSorting": [[0, "asc"]]
//            });
            $("#titulomodal").html("Detalle de consumo");
            
            var neto = 0;
            $("#detallecomanda tr").each(function(){
                var importe = $(this).find("td").eq(3).html(); //Leer el valor que esta en la columna 4 (Importe)
                neto = neto + parseFloat(importe);
            });

            $("#txtimporteneto").val("S/."+neto.toFixed(2));
            
        }else{
            
        }
    });
    
    
}

$("#btncerrar").click(function(){
    $("#txtcodigoproducto").val("");;  
});


function calcularTotales(){
    var neto = 0;
    $("#detallecomanda tr").each(function(){
        var importe = $(this).find("td").eq(3).html(); //Leer el valor que esta en la columna 4 (Importe)
        neto = neto + parseFloat(importe);
    });
    
    $("#txtimporteneto").val(neto.toFixed(2));
    
    }


