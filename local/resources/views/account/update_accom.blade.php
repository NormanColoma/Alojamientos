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
        <div id="newAccom" class="">
            <h3>Actualiza las características del alojamiento</h3>
            {!! Form::open(['url' => 'accommodation/' . $id . "/update", 'files' => true]) !!}
            <div class="form-group form-default">
                <label>Título del anuncio</label>
                <input type="text" name="new-accom-title" class="form-control" value="{!! $accommodation->getTitle() !!}">
                <span class="text-danger">{{ $errors->first('new-accom-title') }}</span>
            </div>
            <div class="row">
                <div class="form-group form-default col-xs-6">
                    <label>Ciudad</label>
                    <input type="text" name="new-accom-city" class="form-control new-accom-city" value="{!! $accommodation->getCity() !!}">
                    <span class="text-danger">{{ $errors->first('new-accom-city') }}</span>
                </div>
                <div class="form-group form-default col-xs-6">
                    <label>Provincia</label>
                    <select name="new-accom-province" class="form-control new-accom-province">
                        <option selected>{!! $accommodation->getCity() !!}</option>
                        <option value='Álava'>Álava</option>
                        <option value='Albacete'>Albacete</option>
                        <option value='Alicante'>Alicante/Alacant</option>
                        <option value='Almería'>Almería</option>
                        <option value='Asturias'>Asturias</option>
                        <option value='Avila'>Ávila</option>
                        <option value='Badajoz'>Badajoz</option>
                        <option value='Barcelona'>Barcelona</option>
                        <option value='Burgos'>Burgos</option>
                        <option value='Cáceres'>Cáceres</option>
                        <option value='Cádiz'>Cádiz</option>
                        <option value='Cantabria'>Cantabria</option>
                        <option value='Castellón'>Castellón/Castelló</option>
                        <option value='Ceuta'>Ceuta</option>
                        <option value='Ciudad Real'>Ciudad Real</option>
                        <option value='Córdoba'>Córdoba</option>
                        <option value='Cuenca'>Cuenca</option>
                        <option value='Girona'>Girona</option>
                        <option value='Las Palmas'>Las Palmas</option>
                        <option value='Granada'>Granada</option>
                        <option value='Guadalajara'>Guadalajara</option>
                        <option value='Guipúzcoa'>Guipúzcoa</option>
                        <option value='Huelva'>Huelva</option>
                        <option value='Huesca'>Huesca</option>
                        <option value='Islas Baleares'>Islas Baleares</option>
                        <option value='Jaén'>Jaén</option>
                        <option value='A Coruña'>A Coruña</option>
                        <option value='La Rioja'>La Rioja</option>
                        <option value='León'>León</option>
                        <option value='LLeida'>Lleida</option>
                        <option value='Lugo'>Lugo</option>
                        <option value='Madrid'>Madrid</option>
                        <option value='Málaga'>Málaga</option>
                        <option value='Melilla'>Melilla</option>
                        <option value='Murcia'>Murcia</option>
                        <option value='Navarra'>Navarra</option>
                        <option value='Ourense'>Ourense</option>
                        <option value='Palencia'>Palencia</option>
                        <option value='Pontevedra'>Pontevedra</option>
                        <option value='Salamanca'>Salamanca</option>
                        <option value='Segovia'>Segovia</option>
                        <option value='Sevilla'>Sevilla</option>
                        <option value='Soria'>Soria</option>
                        <option value='Santa Cruz de Tenerife'>Santa Cruz de Tenerife</option>
                        <option value='Tarragona'>Tarragona</option>
                        <option value='Teruel'>Teruel</option>
                        <option value='Toledo'>Toledo</option>
                        <option value='Valencia'>Valencia/Valéncia</option>
                        <option value='Valladolid'>Valladolid</option>
                        <option value='Vizcaya'>Vizcaya</option>
                        <option value='Zamora'>Zamora</option>
                        <option value='Zaragoza'>Zaragoza</option>
                    </select>
                </div>
            </div>
            <div class="form-group form-default">
                <label>Precio por persona</label>
                <input type="text" name="new-accom-price" class="form-control" value="{!! $accommodation->getPrice() !!}">
                <span class="text-danger">{{ $errors->first('new-accom-price') }}</span>
            </div>
            <div class="row">
                <div class="form-group col-xs-4">
                    <label>Nº de habitaciones</label>
                    <select name="new-accom-beds" class="form-control">
                        <option selected>{!! $accommodation->getBeds() !!}</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                    </select>
                </div>
                <div class="form-group col-xs-4">
                    <label>Nº de aseos</label>
                    <select name="new-accom-baths" class="form-control">
                        <option selected>{!! $accommodation->getBaths() !!}</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                    </select>
                </div>
                <div class="form-group col-xs-4">
                    <label>Nº máximo de personas</label>
                    <select name="new-accom-capacity" class="form-control">
                        <option selected>{!! $accommodation->getCapacity() !!}</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option>13</option>
                        <option>14</option>
                        <option>15</option>
                        <option>16</option>
                        <option>17</option>
                        <option>18</option>
                        <option>19</option>
                        <option>20</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group form-default col-xs-6">
                    <label>Interior</label>
                    <textarea class="form-control" name="new-accom-inside">{!!$accommodation->getInside()!!}</textarea>
                    <span class="text-danger">{{ $errors->first('new-accom-inside') }}</span>
                </div>
                <div class="form-group form-default col-xs-6">

                    <label>Exterior</label>
                    <textarea class="form-control"  name="new-accom-outside">{!!$accommodation->getOutside()!!}</textarea>
                    <span class="text-danger">{{ $errors->first('new-accom-outside') }}</span>
                </div>
            </div>
            <div class="form-group ">
                <label>Descripción del anuncio</label>
                <textarea class="form-control form-desc" name="new-accom-desc">{!! $accommodation->getDesc() !!}</textarea>
                <span class="text-danger">{{ $errors->first('new-accom-desc') }}</span>
            </div>
            <div class="form-group form-submit">
                <input type="submit" class="btn btn-primary" value="Actualizar">
            </div>
            @include('flash::message')
            <script>
                $('#flash-overlay-modal').modal();
            </script>
            {!! Form::close() !!}
            <div class="images">
                <h3>Actualiza las imágenes</h3>
                {!! Form::open(['id' => 'main-img-form', 'files' => true]) !!}
                    <div class="row" style="margin-left: 0px;">
                    <label style="float:left;width: 100%">Imagen principal</label>
                    <div class="current-main-img" id="{!! $accommodation->getMainImg()->getID() !!}">
                        {!! Html::image('/local/resources/assets/img/accoms/' . $accommodation->getMainImg()->getUrl()) !!}
                    </div>
                    <p>Si quieres actualizar la imagen principal de tu alojamiento, solo tienes que seleccionar una nueva imagen. Y pulsar en actualizar imagen.</p>

                    <div class="col-lg-6 col-sm-6 col-12" style="padding:0px;margin-top: 30px;">
                        <label>Selecciona la imagen princiapl</label>
                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-file">
                                                    Principal&hellip; <input type="file" name="new-accom-main-img">
                                                </span>
                                            </span>
                            <input type="text" class="form-control new-accom-main-img-name" readonly >
                        </div>
                        <span>La imagen no puede pesar más de 5mb</span>
                        <span class="text-danger">{{ $errors->first('new-accom-main-img') }}</span>
                    </div>
                        <div class="form-group form-update-main-img">
                            <input type="submit" class="btn btn-success btn-update-main-img" style="margin-top: 20px" value="Actualizar imagen">
                        </div>

                        <div class="alert alert-success main-img-updated" style="display:none">
                            <strong>Actulizada!</strong> La imagen principal ha sido actualizada correctamente.
                        </div>
                        <div class="alert alert-danger main-img-failed" style="display:none">
                            <strong>Error!</strong> Ha habido un error en el servidor, por favor inténtelo de nuevo.
                        </div>
                </div>
                {!! Form::close() !!}
                {!! Form::open(['id' => 'form-gallery', 'files' => true]) !!}
                    <div class="row">
                    <div class="current-img-cont">
                        <label>Galería de imágenes</label>
                            <ul class="current-list-img">
                                @if(count($accommodation->getPhotos()) > 1)
                                    @foreach($accommodation->getPhotos() as $photo)
                                        @if(!$photo->getMain())
                                            <li id="photo-{!! $photo->getId() !!}">
                                                <div class="current-img" id="{!! $photo->getId() !!}">
                                                    {!! Html::image('/local/resources/assets/img/accoms/' . $photo->getUrl()) !!}
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="empty-list-message">
                                        <p>Todavía no has añadido ninguna foto a la galería. Comienza ya añadir tus imágenes</p>
                                    </li>
                                @endif
                            </ul>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-12 col-gallery">
                        <label>Selecciona las imágenes de la galería</label>
                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-primary btn-file">
                                                    Galería&hellip; <input type="file" multiple name="galery[]" id="massive-image">
                                                </span>
                                            </span>
                            <input type="text" class="form-control" readonly>
                        </div>
                        <span>Solo puedes subir un máximo de 6 imágenes (5mb máximo por imagen)</span>
                        <span class="text-danger" style="float:left;">{{ $errors->first('galery') }}</span>
                        <p>Selecciona aquellas imágenes de la galería que deseas borrar (pinchando en ellas) y elimínalas. A continuación, selecciona las nuevas que deseas subir, y pulsa
                            el botón "Actualizar Galería".Si no quieres modificarlas, déjalas como están. Si quieres desmarcalas, vuelve a pinchar en las que estén marcadas.</p>
                        <div class="form-group options-gallery">
                            <a class="btn btn-danger btn-delete-gallery"><span class="glyphicon glyphicon-remove"></span> Eliminar Selección</a>
                            <input type="submit" class="btn btn-success btn-update-galery"  value="Actualizar Galería" id="{!! $id !!}">
                        </div>
                        <div class="alert alert-danger gallery-excess" style="display: none; float:left; width:100%">
                            <strong>Demasiadas imágenes!</strong> La galaería no puede contener más de 6 imágenes
                        </div>
                        <div class="alert alert-danger gallery-empty" style="display: none; float:left; width:100%">
                            <strong>Selecciona imágenes!</strong> Selecciona las imágenes que quieres subir a la galería
                        </div>
                        <div class="alert alert-success gallery-deleted" style="display: none; float:left; width:100%">
                            <strong>Imagenes eliminadas!</strong> Las imagenes seleccionadas han sido eliminadas de la galería
                        </div>
                        <div class="alert alert-success gallery-updated" style="display: none; float:left; width:100%">
                            <strong>Galería actualizada!</strong> La galería ha sido actualizada correctamente
                        </div>
                    </div>
                        {!! Form::close() !!}
                    <script>
                        $(document).ready(function(){

                            $(".current-img").click(function (){
                                if($(this).css("border-color") === "rgb(255, 0, 0)")
                                    $(this).css("border-color", "#dce0e0");
                                else
                                    $(this).css("border-color","rgb(255,0,0)");
                            })

                            $(".btn-delete-gallery").click(function(){
                                var to_erase = "";
                                $(".current-img").each(function(){
                                    if($(this).css("border-color") === "rgb(255, 0, 0)"){
                                        deletePhoto($(this).attr("id"));
                                    }
                                })
                            })
                            $("#main-img-form").submit(function(){
                                var id = $(".current-main-img").attr("id");
                                var port = location.port;
                                var uri = "http://localhost:" + port + "/alojamientos/photo/update/" + id;
                                var formData = new FormData($(this)[0]);
                                var new_img = $(".new-accom-main-img-name").val();
                                $.ajax({
                                    url: uri,
                                    type: 'POST',
                                    data: formData,
                                    async: false,
                                    success: function (data) {
                                       if(data.ok){
                                           updateMainImg(new_img);
                                       }

                                    },error: function(){
                                      alert("error")
                                    },
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });

                                return false;
                            });

                            $("#form-gallery").submit(function(){
                                var current_items = $(".current-list-img li").length;
                                var photos = document.getElementById('massive-image');
                                var upload_items = document.getElementById('massive-image').files.length;
                                var total_items = upload_items+current_items;
                                if(total_items > 6 || current_items == 6){
                                    $(".gallery-excess").show();
                                    $(".alert").delay(3000).slideUp(200);
                                }
                                else if(upload_items == 0){
                                    $(".gallery-empty").show();
                                    $(".alert").delay(3000).slideUp(200);
                                }
                                else{
                                    var formData = new FormData($(this)[0]);
                                    var id = $(".btn-update-galery").attr("id");
                                    var port = location.port;
                                    var uri = "http://localhost:" + port + "/alojamientos/gallery/update/" + id;
                                    $.ajax({
                                        url: uri,
                                        type: 'POST',
                                        data: formData,
                                        async: false,
                                        success: function (data) {
                                            if(data.ok){
                                                updateGallery(data.photos);
                                            }
                                        },
                                        cache: false,
                                        contentType: false,
                                        processData: false
                                    });
                                }
                                return false;
                            })
                            function updateMainImg(new_img){
                                var port = location.port;
                                var src = "http://localhost:" + port + "/alojamientos/local/resources/assets/img/accoms/" + new_img;
                                $(".current-main-img").find("img").attr("src",src);
                                $(".main-img-updated").show();
                                $(".alert").delay(3000).slideUp(200);
                            }

                            function updateGallery(photos){
                                var port = location.port;
                                var ids = new Array();
                                $(".empty-list-message").remove();
                                $(".current-list-img li").each(function(){
                                    ids.push($(this).attr("id"));
                                })
                                var ini =  ids.length;
                                for(var i=ini;i<photos.length;i++){
                                    var li = "<li><div class='current-img' id='"+photos[i].id+"'><img src='http://localhost:"+port+"/alojamientos/local/resources/assets/img/accoms/"+photos[i].url+"'></div></li>";
                                    $(".current-list-img").append(li);
                                }
                                $(".gallery-updated").show();
                                $(".alert").delay(3000).slideUp(200);
                            }

                            function deletePhoto(id) {
                                var port = location.port;
                                var uri = "http://localhost:" + port + "/alojamientos/photo/delete/" + id;
                                $.ajax({
                                    type: "Delete",
                                    url: uri,
                                    success: function (data) {
                                        $("#photo-"+id).remove();
                                        $(".gallery-deleted").show();
                                        $(".alert").delay(3000).slideUp(200);
                                    }, error: function () {
                                        alert("bad")
                                    }
                                });
                            }

                            $(function() {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                            });
                        })
                    </script>
                </div>
                {!! Form::close() !!}
            </div>
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
                    <input type="button" class="btn btn-primary btn-clear-schedule" value="Resetear calendario">
                    <input type="button" class="btn btn-danger btn-remove-schedule" value="Borrar calendario" id="{!! $id !!}">
                    <div class="alert alert-success schedule-deleted" style="display: none; float:left; width:100%">
                        <strong>Calendario eliminado!</strong> El calendario de ocupación ha sido eliminado correctamente
                    </div>
                </div>
                <script>
                    //$('#datepicker').datepicker('datesDisabled', new Date(2015, 8, 29));
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
                                if(data.ok) {
                                    $('#datepicker').datepicker('remove');
                                    $('#datepicker').datepicker({
                                        multidate: true,
                                    });
                                    $(".schedule-deleted").show();
                                    $(".alert").delay(3000).slideUp(200);
                                }
                            }, error: function () {
                                alert("bad")
                            }
                        });
                    }
                </script>
                {!! Form::close() !!}
            </div>
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
            </script>
        </div>
    </div>
@include("include.footer")
</body>
</html>