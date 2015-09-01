<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Control Panel</title>
    {!! Html::style('/local/resources/assets/styles/owner_panel.css') !!}
    <meta name="csrf-token" content="<?= csrf_token() ?>">
</head>
<body>
    @include("include.header")
    <div class="container container-height">
        @include('flash::message')
        <div class="schedule">
            {!! Form::open(['url' => 'accommodation/' . $id . "/schedule",'id' => 'form-calendar', 'files' => true]) !!}
            <h3>Calendario de ocupación</h3>
            <div id="datepicker"></div>
            <input type="hidden" id="my_hidden_input" name="calendar" />
            <div class="schedule-info">
                <p>Selecciona las fechas que no estén disponibles, para marcarlas como ocupadas. A continucación pulsa "Actualizar calendario"
                    para actualizar el calendario de ocupación. Si deseas desmarcar alguna fecha, solo tienes que volver a pulsarla. Si deseas desmarcarlas todas pulsa
                    "Resetear calendario". Si deseas borrar el calendario, pulsa "Borrar calendario" y se borrará.</p>
                <input type="submit" class="btn btn-success btn-update-schedule" value="Actualizar calendario" id="{!! $id !!}">
                <input type="button" class="btn btn-grey btn-clear-schedule" value="Resetear calendario">
                <input type="button" class="btn btn-danger btn-remove-schedule" value="Borrar calendario" id="{!! $id !!}">
                <div class="alert alert-success schedule-deleted" style="display: none; float:left; width:100%">
                    <strong>Calendario eliminado!</strong> El calendario de ocupación ha sido eliminado correctamente
                </div>
                <div class="alert alert-danger schedule-empty" style="display: none; float:left; width:100%; margin-top: 20px">
                    <strong>Calendario vacío!</strong> El calendario de ocupación está vacío por el momento
                </div>
            </div>
            <script>
                $('#flash-overlay-modal').modal();
                $("#datepicker").on("changeDate", function(event) {
                    $("#my_hidden_input").val(
                            $("#datepicker").datepicker('getFormattedDate')
                    )
                });

                $(document).ready(function(){
                    getSchedule();

                    $(".btn-clear-schedule").click(function(){
                        clearSchedule();
                    })

                    $(".btn-remove-schedule").click(function(){
                        deleteSchedule();
                    })

                    $(".btn-update-schedule").click(function(){
                        updateSchedule();
                    })
                })

                function updateSchedule(){
                    var id = $(".btn-update-schedule").attr("id");
                    var port = location.port;
                    var uri = "http://localhost:" + port + "/alojamientos/accommodation/" + id+"/schedule/";
                    $.ajax({
                        type: "POST",
                        url: uri,
                        data: $("#form-calendar").serialize(),
                        success: function(data) {
                            alert(data);
                        }
                    });
                }
                function clearSchedule(){
                    $('#datepicker').datepicker('update', '');
                }

                function getSchedule(){
                    var id = $(".btn-update-schedule").attr("id");
                    var port = location.port;
                    var uri = "http://localhost:" + port + "/alojamientos/accommodation/" + id+"/schedule";
                    $.ajax({
                        type: "Get",
                        url: uri,
                        async: true,
                        success: function (data) {
                            if(data.message == "Schedule is empty"){
                                $('#datepicker').datepicker({
                                    multidate: true,
                                });
                            }
                            else if(data.message == "Schedule was retrieved") {
                                var disabled_dates = new Array();
                                for (var i = 0; i < data.schedule.length; i++) {
                                    disabled_dates.push(new Date(data.schedule[i].year, parseInt(data.schedule[i].month) - 1, parseInt(data.schedule[i].day) + 1));
                                }
                                setDatePicker(disabled_dates);
                            }
                        }, error: function () {
                            alert("bad")
                        }
                    });

                    function setDatePicker(disabled_dates){
                        $('#datepicker').datepicker({
                            multidate: true,
                            datesDisabled: disabled_dates,
                        });
                    }
                }


                function deleteSchedule() {
                    var id = $(".btn-remove-schedule").attr("id");
                    var port = location.port;
                    var uri = "http://localhost:" + port + "/alojamientos/accommodation/" + id + "/schedule";
                    $.ajax({
                        type: "Delete",
                        url: uri,
                        success: function (data) {
                                $('#datepicker').datepicker('remove');
                                $('#datepicker').datepicker({
                                    multidate: true,
                                });
                                $(".schedule-deleted").show();
                                $(".alert").delay(3000).slideUp(200);

                        }, error: function () {
                            $(".schedule-empty").show();
                            $(".alert").delay(3000).slideUp(200);
                        }
                    });
                }
            </script>
            <script>
                $(document).on('change', '.btn-file :file', function() {
                    var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [numFiles, label]);
                });
                $(document).ready( function() {
                    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

                        var input = $(this).parents('.input-group').find(':text'),
                                log = numFiles > 1 ? numFiles + ' files selected' : label;

                        if( input.length ) {
                            input.val(log);
                        } else {
                            if( log ) alert(log);
                        }

                    });
                });

                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                });
            </script>
            {!! Form::close() !!}
        </div>
    </div>
    @include("include.footer")
</body>
</html>