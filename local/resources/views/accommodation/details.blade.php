<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Details page</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    {!! Html::style('/local/resources/assets/styles/details.css') !!}
</head>
<body>
@include("include.header")
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Envía tu mensaje de prereserva</h4>
            </div>
            <div class="modal-body"><textarea placeholder="Escribe aquí tu mensaje"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-default btn-send-booking">Enviar</button>
            </div>
        </div>

    </div>
</div>
<div class="container container-height">
    @include('flash::message')
    <div class="accommodation-container">
        <div class="accommodation-main-container">
            <h2 class="accommodation-title">{!! $accomm->getTitle() !!}</h2>
            <h4 class="accommodation-location"><span class="glyphicon glyphicon-map-marker"></span> {!! $accomm->getCity() !!}, {!! $accomm->getProvince() !!}</h4>
            <div id="main_area">
                <!-- Slider -->
                <div class="row">
                    <div class="col-xs-12" id="slider">
                        <!-- Top part of the slider -->
                        <div class="row">
                            <div class="col-sm-8" id="carousel-bounding-box">
                                <div class="carousel slide" id="myCarousel">
                                    <!-- Carousel items -->
                                    <div class="carousel-inner">
                                        <?php $i = 0 ?>
                                        @foreach($accomm->getPhotos() as $photo)
                                            @if($photo->getMain())
                                                <div class="active item" data-slide-number="{!! $i !!}">
                                                    {!! Html::image('/local/resources/assets/img/accoms/' . $photo->getUrl()) !!}
                                                </div>
                                            @else
                                                <div class="item" data-slide-number="{!! $i !!}">
                                                    {!! Html::image('/local/resources/assets/img/accoms/' . $photo->getUrl()) !!}
                                                </div>
                                            @endif
                                            <?php $i++ ?>
                                        @endforeach
                                    </div><!-- Carousel nav -->
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-4" id="carousel-text"></div>


                        </div>
                    </div>
                </div><!--/Slider-->

                <div class="row hidden-xs" id="slider-thumbs">
                    <!-- Bottom switcher of slider -->
                    <ul class="hide-bullets">
                        <?php $i = 0 ?>
                        @foreach($accomm->getPhotos() as $photo)
                            <li class="col-sm-2">
                                <a class="thumbnail" id="carousel-selector-{!! $i !!}">
                                    {!! Html::image('/local/resources/assets/img/accoms/' . $photo->getUrl()) !!}
                                </a>
                            </li>
                            <?php $i++?>
                        @endforeach
                    </ul>
                </div>
                <script>
                    jQuery(document).ready(function($) {

                        $('#myCarousel').carousel({
                            interval: 5000
                        });

                        $('#carousel-text').html($('#slide-content-0').html());

                        //Handles the carousel thumbnails
                        $('[id^=carousel-selector-]').click( function(){
                            var id = this.id.substr(this.id.lastIndexOf("-") + 1);
                            var id = parseInt(id);
                            $('#myCarousel').carousel(id);
                        });


                        // When the carousel slides, auto update the text
                        $('#myCarousel').on('slid.bs.carousel', function (e) {
                            var id = $('.item.active').data('slide-number');
                            $('#carousel-text').html($('#slide-content-'+id).html());
                        });
                    });
                </script>
            </div>
            <div class="accommodation-about">
                <ul>
                    <li class="prebooking-row">
                        <h3 class="accommodation-about-info">Resérvalo ya</h3>
                        <div class="accommodation-right-bar-side-inner">
                            <form>
                                <div class="form-group">
                                    <div class='form-div date date-margin'>
                                        <span class="glyphicon glyphicon-calendar"></span>
                                        <input class="form-control datepicker check-in" id="avialableDate" name="check-in" type="text" placeholder="Llegada">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class='form-div date'>
                                        <span class="glyphicon glyphicon-calendar" style="top: 55%;"></span>
                                        <input class="form-control datepicker check-out" id="avialableDate" name="check-out" type="text" placeholder="Salida">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="button" class="btn btn-grey btn-prebooking" value="Prereservar">
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <h3 class="accommodation-about-info">Detalles del alojamiento</h3>
                        <ul class="accommodation-about-info-list">
                            <li>{!! $accomm->getBeds() !!} habitaciones</li>
                            <li>{!! $accomm->getBaths() !!} baños</li>
                            <li>Máximo {!! $accomm->getCapacity() !!} personas</li>
                            <li>
                                <h4>Interior</h4>
                                <p>{!! $accomm->getInside() !!}</p>
                            </li>
                            <li>
                                <h4>Exterior</h4>
                                <p>{!! $accomm->getOutside() !!}</p>
                            </li>
                        </ul>
                    </li>
                    <li><h3 class="accommodation-about-info">Descripción</h3>
                        <p>{!! $accomm->getDesc() !!}</p>
                    </li>
                    <li><h3 class="accommodation-about-info">Precio y condiciones</h3>
                        <ul class="accommodation-about-info-list">
                            <li>
                                <h4>Precio</h4>
                                <p>Precio por noche <span>{!! $accomm->getPrice() !!} €</span></p>
                            </li>
                            <li>
                                <h4>Condiciones</h4>
                                <p>Las condiciones deben ser discutidas con el propietario del alojamiento. Para ello, ponte en contacto con él, o realiza
                                    una prereserva para que te él pueda informarte de las mismas.</p>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <h3 class="accommodation-about-info">
                            Calendario de ocupación
                        </h3>
                        <div class="form-group form-schedule">
                            <div id="datepicker"></div>
                            <input type="hidden" id="my_hidden_input" name="calendar" />
                            <input type="hidden" id="{!! $accomm->getID() !!}" class="hidden-id">
                            <p>Este es el calendario de ocupación actual en el que usted podrá ver las fechas
                                que se encuentran disponibles para este alojamiento. Tenga en cuenta que estás fechas podrían
                                sufrir modificaciones por parte del propietario en cualquier momento</p>
                        </div>
                    </li>
                    <li><h3 class="accommodation-about-info">Comentarios y valoración</h3>
                    </li>
                </ul>
            </div>
        </div>
        <div class="accommodation-right-bar-side-container">
            <div class="inner-title">
                <h3>Resérvalo ya</h3>
            </div>
            <div class="accommodation-right-bar-side-inner">
                {!! Form::open(['url' => 'accommodation/' . $id . '/book', 'id'=> 'booking-form']) !!}
                    <div class="form-group">
                        <div class='form-div date date-margin'>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input class="form-control datepicker check-in" id="avialableDate" name="check-in" type="text" placeholder="Llegada">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class='form-div date'>
                            <span class="glyphicon glyphicon-calendar" style="top: 55%;"></span>
                            <input class="form-control datepicker check-out" id="avialableDate" name="check-out" type="text" placeholder="Salida">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="button" class="btn btn-grey btn-prebooking" value="Prereservar">
                    </div>
                    <script>
                        $(document).ready(function(){
                            getSchedule();
                            $(".btn-prebooking").click(function(){
                                $("#myModal").modal();
                            })

                            $(".btn-send-booking").click(function(){
                                $("#booking-form").submit();
                            })
                        })
                        function getSchedule() {
                            var id = $(".hidden-id").attr("id");
                            var port = location.port;
                            var uri = "http://localhost:" + port + "/alojamientos/accommodation/" + id + "/schedule";
                            $.ajax({
                                type: "Get",
                                url: uri,
                                async: true,
                                success: function (data) {
                                    if (data.message == "Schedule is empty") {
                                        $( ".datepicker" ).datepicker();
                                        $('#datepicker').datepicker();
                                    }
                                    else if (data.message == "Schedule was retrieved") {
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
                        }

                            function setDatePicker(disabled_dates){
                                $('.datepicker').datepicker({
                                    datesDisabled: disabled_dates,
                                });
                                $('#datepicker').datepicker({
                                    datesDisabled: disabled_dates,
                                });
                            }
                    </script>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@include("include.footer")
</body>
</html>