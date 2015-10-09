<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/search.css">

</head>
<body>
@include("include.header")
<div class="container-top">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
            <li data-target="#myCarousel" data-slide-to="4"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="./local/resources/assets/img/carousel/cazorla.jpg" alt="Chania">

            </div>

            <div class="item">
                <img src="./local/resources/assets/img/carousel/benaojan.jpg" alt="Chania">

            </div>

            <div class="item">
                <img src="./local/resources/assets/img/carousel/hornachuelos.jpg" alt="Flower">

            </div>

            <div class="item">
                <img src="./local/resources/assets/img/carousel/ronda.jpg" alt="Flower">

            </div>
            <div class="item">
                <img src="./local/resources/assets/img/carousel/zahara.jpg" alt="Flower">

            </div>
        </div>
    </div>

    <div class="search-cont">
        <form method="post" action="search/accommodations" id="searchForm">
            {!! csrf_field() !!}
            <div class="inner">
                <ul>
                    <li>
                        <h4>Destino</h4>
                        <div class='form-div'>
                            <span class="glyphicon glyphicon-map-marker"></span><input class="form-control" type="text" placeholder="Ciudad" name="city">
                        </div>
                        <span class="text-danger text-search-danger" style="color:red;font-weight:700;float:left" id="text-search-danger"></span>
                    </li>
                    <li>

                        <div class='form-div date date-margin'>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input class="form-control datepicker" id="avialableDate" name="check-in" type="text" placeholder="Llegada">
                        </div>
                        <div class='form-div date'>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input class="form-control datepicker" id="avialableDate" name="check-out" type="text" placeholder="Salida">
                        </div>
                    </li>
                    <li>
                        <div>
                            <input type="submit" class="form-control btn-primary btn-search" value="BUSCAR">
                        </div>
                    </li>
                    <script>
                        $(function() {
                            $( ".datepicker" ).datepicker();
                        });
                    </script>
                </ul>
            </div>
            <script>
                $("#searchForm").submit(function(e){
                    if(!$('[name="city"]').val()){
                        $(".text-search-danger").text("Introduce la ciudad")
                        e.preventDefault();
                    }
                })
            </script>
        </form>
    </div>
    <div class="container highlights">

        @if(count($highlights) > 0)
            <div class="highlights-title">
                <h2>Para el fin de semana</h2>
                <p>Descubre los alojamientos más destacos</p>
            </div>
            <ul>
                    @foreach($highlights as $accom)
                        <?php
                        $am = new \App\Models\AccommodationModel();
                        foreach($am->allPhotos($accom->getId()) as $photo){
                            if($photo->getMain())
                                $img = $photo->getUrl();
                        }
                        ?>
                        <li>
                            <div class="accom">
                                {!! Html::image('/local/resources/assets/img/accoms/'.$img ) !!}
                                <div class="description">
                                    <span class="city">{!! $accom->getTitle() !!}</span>
                                    <p>{!! $accom->getDesc() !!}</p>
                                </div>
                                <div class="show_details">
                                    <span class="price">Desde  {!! $accom->getPrice() !!}€/noche</span>
                                    <a href="{!! Url::to("accommodation/". $accom->getID() ."/details") !!}" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
            </ul>
        @else
            <div class="highlights-title">
                <h2>Para el fin de semana</h2>
                <p>Todavía no hay alojamientos destacados</p>
            </div>
        @endif
    </div>
    <div class="info-app">
        <div class="container">
            <div class="traveler">
                <h3>Lo que puedes hacer como viajero...</h3>
                <ul>
                    <li><img src="./local/resources/assets/img/hoja_blanca.png"><p>Ponemos a tu disposición un buscador de alojamientos rurales donde podrás
                            consultar por la ciudad o por las fechas deseadas.</p></li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Gracias a su calendario de ocupación conocerás en todo momento la disponibilidad
                            del alojamiento.</p>
                    </li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Realizar la reserva del alojamiento rural que desee sin necesidad de llamadas
                            telefónicas.</p>
                    </li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Podrás dejar un comentario y una valoración global de su estancia en el
                            alojamiento.</p>
                    </li>
                </ul>
            </div>
            <div class="owner">
                <h3>Lo que puedes hacer como propietario...</h3>
                <ul>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Podrán registrar más de un alojamiento rural y gestionar los datos básicos
                            de cada uno de ellos.</p>
                    </li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Consultar las pre-reservas realizadas por los viajeros y covertirlas en reservas
                            una vez confirmadas.</p>
                    </li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Actualizar el correspondiente calendario de ocupación de cada alojamiento.</p>
                    </li>
                    <li>
                        <img src="./local/resources/assets/img/hoja_blanca.png"><p>Podrán almacenar la información de los viajeros e incluir una nota informativa
                            sobre los mismos.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="comentaries">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        @if(count($commentaries) == 0)
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img src="./local/resources/assets/img/transparent.png" alt="First slide">
                                    <div class="carousel-caption">
                                        <h3 class="comment">Todavía no se ha realizado ningún comentario</h3>
                                    </div>
                                </div>
                            </div>
                        @else
                            @if(count($commentaries) == 1)
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            </ol>
                            @elseif(count($commentaries) == 2)
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            </ol>
                            @else
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                                </ol>
                            @endif
                            <div class="carousel-inner">
                                <?php $i = 0; ?>
                                @foreach($commentaries as $c)
                                    @if($i == 0)
                                        <div class="item active">
                                            <img src="./local/resources/assets/img/transparent.png" alt="First slide">
                                            <div class="carousel-caption" id="{!! $c->getAccomId() !!}">
                                                <h3 class="comment">{!! $c->getText() !!}</h3>
                                                <p class="autor">Juan Francisco López</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="item">
                                            <img src="./local/resources/assets/img/transparent.png" alt="First slide">
                                            <div class="carousel-caption" id="{!! $c->getAccomId() !!}">
                                                <h3 class="comment">{!! $c->getText() !!}</h3>
                                                <p class="autor">Juan Francisco López</p>
                                            </div>
                                        </div>
                                    @endif
                                    <?php $i++; ?>
                                @endforeach
                            </div>
                        @endif
                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control"
                                                                                         href="#carousel-example-generic" data-slide="next"><span class="glyphicon glyphicon-chevron-right">
                        </span></a>
                    </div>
                    <div class="main-text hidden-xs">
                        <div class="col-md-12 text-center">
                            <h1 col>Nuestra Comunidad</h1>
                            <p>Lee lo que nuestros viajeros opinan</p>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(".carousel-caption").click(function(){
                    var id = $(this).attr("id");
                    var port = location.port;
                    var uri = "http://localhost:" + port + "/alojamientos/accommodation/"+id+"/details";
                    window.location = uri;
                })
            </script>
        </div>
        <div id="push">
        </div>
    </div>
</div>
@include("include.footer")
</body>
</html>
