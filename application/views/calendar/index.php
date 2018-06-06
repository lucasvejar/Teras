<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Calendar Display</title>
        <!-- Estilo del bootsrap -->
        <link rel="stylesheet" type="text/css" href="/Teras/css/bootstrap.min.css" />

        <!-- JQuery y el Js del Bootstrap -->
        <script src="/Teras/js/jquery-3.3.1.min.js" ></script>
        <script src="/Teras/js/bootstrap.min.js"></script>

        <!-- Scrips del fullCalendar -->
        <link rel="stylesheet" type="text/css" href="/Teras/scripts/fullcalendar/fullcalendar.min.css" />
        <script src="/Teras/scripts/fullcalendar/lib/moment.min.js"></script>
        <script src="/Teras/scripts/fullcalendar/fullcalendar.min.js"></script>
        <script src="/Teras/scripts/fullcalendar/gcal.js"></script>

        <!-- En este js se definen los eventos que van a estar dentro del calendario  -->
        <script type="text/javascript">

            $(document).ready(function() {
                $.post('<?php echo base_url(); ?>calendar/traeEvento',function(data){

                    $('#calendar').fullCalendar({
                        header: {
                            left:'prev,next today',
                            center:'title',
                            right:'month,basicWeek,basicDay'
                        },
                        defaultDate: new Date(),
                        navLinks: false,
                        editable: true,
                        eventLimit: true,
                        events: $.parseJSON(data),
                        eventDrop: function(event, delta, revertFunc){
                            var id = event.id;
                            var fi = event.start.format();

                            if (!confirm("Esta seguro??")) {
                                revertFunc();
                            }else{
                                $.post("<?php echo base_url(); ?>calendar/modificaFechaEvento",
                                       {
                                    id:id,
                                    fecha_inicio:fi,
                                    fecha_fin:fi    // La fecha de inicio y de fin son las mismas
                                },
                                function(data){
                                    if (data == 1) {
                                        alert('Se actualizo correctamente');
                                    }else{
                                        alert('ERROR.');
                                    }
                                });
                            }
                        },
                        eventClick: function(event,jsEvent,view){
                            $('#mtitulo').html(event.title);
                            $('#idEvento').val(event.id);
                            $('#textNombreEvento').val(event.title);
                            $('#textDescripcionEvento').val(event.description);
                            $('#modalEvento').modal();
                        }
                    });


                });

            });
        </script>

    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h1>Calendario</h1>

                   <!-- Dentro de este div=calendar va estar nuestro calendario -->
                    <div id="calendar"></div>


                    <!-- Modal que permite modificar eventos y borrarlos -->
                    <div class="modal fade" id="modalEvento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-red">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="mtitulo"></h4>
                                </div>

                                <!-- Cuerpo del modal -->
                                <div class="modal-body">

                                    <form>
                                        <div class="form-group row">
                                            <input type="hidden" id="idEvento" >  <!-- Este es un campo hidden que me sirve para traer el id del evento -->
                                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Nombre Evento: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="textNombreEvento" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm">Descripci&oacute;n: </label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-sm" id="textDescripcionEvento" >
                                            </div>
                                        </div>
                                    </form>

                                </div>

                               <!-- footer del modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" id="btnCerrarModal" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="btnEliminarEvento">Eliminar Evento</button>
                                    <button type="button" class="btn btn-success" id="btnUpdEvento">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pregunta si en realidad desea hacer la accion -->
                    <div class="modal fade" id="modalPregunta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterTitle">Esta seguro de realizar esta acci&oacute;n? </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnCancelar" >Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btnAceptar" >Aceptar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

    <script type=text/javascript>
        $('#btnUpdEvento').click(function(){
            var idEvento = $('#idEvento').val();
            var nombreEvento = $('#textNombreEvento').val();
            var descripcionEvento = $('#textDescripcionEvento').val();
            $.post("<?php echo base_url(); ?>calendar/modificarEvento",
                  {
                    id: idEvento,
                    nombre: nombreEvento,
                    descripcion: descripcionEvento
                  },
                function(data){
                    if (data == 1){
                        //---> viene por este lado entonces cierro la ventana modal, se guardo bien el cambio
                        $('#btnCerrarModal').click();
                    } else{
                        // ---> Si vino por este lado quiere decir que no se pudo realizar el cambio, o no se modifico nada
                        //----> entonces lo unico que hago es cerrar la ventana modal
                        $('#btnCerrarModal').click();
                    }
                });
        });
    </script>
    <script type="text/javascript">
        $('#btnEliminarEvento').click(function(){
            $('#modalPregunta').modal();  //--> abre el modal de pregunta si en realidad quiere realizar esa accion
        });
    </script>
    <script type="text/javascript">
        $('#btnAceptar').click(function(){
            var idEvento = $('#idEvento').val();

            $.post("<?php echo base_url(); ?>calendar/borrarEvento",
                   {
                id: idEvento
            },
            function(data){
                // ---> Borra el elemento del calendario
                $("#calendar").fullCalendar('removeEvents', idEvento);
                //----> cierra los dos modales abiertos
                $('#btnCerrarModal').click();
                $('#btnCancelar').click();
            });
        });
    </script>

    </body>
</html>
