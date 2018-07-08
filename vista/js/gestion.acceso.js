$(document).ready(function () {
    navegacion();
    cargarComboCargo("#cboCargo");
    cargarComboMenu("#cboMenu");
    $("#btnGuardar").attr("disabled",true);
});

function cargarComboCargo(p_nombreCombo) {
    $.post("../controlador/cargo.listar.controlador.php"
            ).done(function (resultadoCargo) {
        var datosJSON = resultadoCargo;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="-1">Seleccione un cargo</option>';
            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_cargo + '">' + item.descripcion + '</option>';
            });

            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultadoCargo, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarComboMenu(p_nombreCombo) {

    $.post("../controlador/acceso.opciones.menu.controller.php"
            ).done(function (resultadoOpcionesMenuBD) {
        var datosJSON = resultadoOpcionesMenuBD;

        if (datosJSON.estado === 200) {
            var html = "";
            html += '<option value="-1">Seleccione un menú</option>';
            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_menu + '">' + item.nombre + '</option>';
            });

            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultadoOpcionesMenuBD, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

$("#cboMenu").change(function () {
    var codigoCargo = $("#cboCargo").val();
    var codigoMenu = $("#cboMenu").val();
    if (codigoCargo !== "-1" && codigoMenu !== "-1") {
        listar();
        $("#btnGuardar").removeAttr("disabled");
    }else{
        $("#btnGuardar").attr("disabled",true);
    }
})

$("#cboCargo").change(function () {
    var codigoCargo = $("#cboCargo").val();
    var codigoMenu = $("#cboMenu").val();
    if (codigoCargo !== "-1" && codigoMenu !== "-1") {
        listar();
        $("#btnGuardar").removeAttr("disabled");
    }else{
        $("#btnGuardar").attr("disabled",true);
    }
})

function listar() {
    var codigoCargo = $("#cboCargo").val();
    var codigoMenu = $("#cboMenu").val();

    $.post("../controlador/acceso.opciones.menu.item.controller.php",
            {
                codigo_cargo_usuario: codigoCargo,
                codigo_menu: codigoMenu
            }
    ).done(function (resultadoOpcionesMenuItemBD) {
        var datosJSON = resultadoOpcionesMenuItemBD;
        if (datosJSON.estado === 200) {
            var html = "";
            html += '<table id="tblAcceso" class="table table-striped table-bordered dt-responsive nowrap">';
            html += ' <thead>';
            html += '   <tr style="background-color: #ededed; height: 40px;">';
            html += '       <th style="text-align: center">ITEM DEL MENÚ</th>';
            html += '       <th style="text-align: center">ACCESO</th>';
            html += '   </tr>';
            html += ' </thead>';
            html += ' <tbody>';
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '   <td align="center">';
                html += '       ' + item.nombre;
                html += '       <input type="hidden" name="codigo[]"  value="' + item.codigo_menu_item + '">';
                html += '   </td>';
                html += '   <td align="center">';
                html += '       <div class="form-group">';
                if (item.acceso === "1") {
                    html += '           <label class="col-sm-6">';
                    html += '               <input type="radio" name="radio[' + i + ']" class="color-radio" value="1" checked> Si';
                    html += '           </label>';
                    html += '           <label class="col-sm-6">';
                    html += '               <input type="radio" name="radio[' + i + ']" class="color-radio" value="0"> No';
                    html += '           </label>';
                } else {
                    html += '           <label class="col-sm-6">';
                    html += '               <input type="radio" name="radio[' + i + ']" class="color-radio" value="1"> Si';
                    html += '           </label>';
                    html += '           <label class="col-sm-6">';
                    html += '               <input type="radio" name="radio[' + i + ']" class="color-radio" value="0" checked> No';
                    html += '           </label>';
                }

                html += '       </div>';
                html += '   </td>';
                html += '</tr>';
            });
            html += ' </tbody>';
            html += '</table>';
            $("#tabla-listado").html(html);
            
            $('#tblAcceso').dataTable({
                "aaSorting": [[1, "asc"]]
            });

            //aqui se le cambia el color al radio button
            $('input[type="radio"].color-radio').iCheck({
                radioClass: 'iradio_flat-green'
            })

        } else {
            swal("Mensaje del sistema", resultadoOpcionesMenuItemBD, "warning");
        }

    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

$("#formGuardarAcceso").submit(function (evento) {
    evento.preventDefault();
    swal({
        title: "Confirme",
        text: "¿Esta seguro de grabar los cambios?",
        showCancelButton: true,
        confirmButtonColor: '#3d9205',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/pregunta.png"
    },
            function (isConfirm) {

                if (isConfirm) { //el usuario hizo clic en el boton SI                      

                    $.post("../controlador/acceso.editar.controller.php",
                            {
                                p_datos: $("#formGuardarAcceso").serialize()
                            }
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) {
                            listarOpcionesMenu();
                            swal("Exito", datosJSON.mensaje, "success");
                        } else {
                            swal("Mensaje del sistema", resultado, "warning");
                        }

                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                } else { //cuando presiona en no
                    listar();
                }
            });
});