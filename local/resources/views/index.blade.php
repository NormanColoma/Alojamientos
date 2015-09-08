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
        <div class="highlights-title">
            <h2>Para el fin de semana</h2>
            <p>Descubre los alojamientos más destacos</p>
        </div>
        <ul>
                <li>
                    <div class="accom">
                        <img src="./local/resources/assets/img/highlights/highlights-1.jpg">
                        <div class="description">
                            <span class="city">Casa Rural El Refugio</span>
                            <p>Situada en pleno P.N. de la Sierra de Hornachuelos. Dispone de 1200 metros, la mayor parte de ellos corresponden a zona ajardinada.</p>
                        </div>
                        <div class="show_details">
                            <span class="price">Desde  40€/noche</span>
                            <a href="" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                        </div>
                    </div>
                </li>
            <li>
                <div class="accom">
                    <img src="./local/resources/assets/img/highlights/highlights-2.JPG">
                    <div class="description">
                        <span class="city">Hacienda El Cortijo</span>
                        <p>Casa llena de encanto y situada en un entorno privilegiado de P.N. de Cazorla, Segura y las Villas y a 30 minutos de las ciudades renacentistas de Úbeda y Baeza.</p>
                    </div>
                    <div class="show_details">
                        <span class="price">Desde  50€/noche</span>
                        <a href="" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="accom">
                    <img src="./local/resources/assets/img/highlights/highlights-3.jpg">
                    <div class="description">
                        <span class="city">Casa Rural Mirador de Ronda</span>
                        <p>Situada en plena naturaleza a sólo 2 Km de la bella ciudad de Ronda. La parcela dispone de 10.000m2 con vistas al famoso Tajo y a las sierras de Ronda.</p>
                    </div>
                    <div class="show_details">
                        <span class="price">Desde  150€/noche</span>
                        <a href="" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                    </div>
                </div>
            </li>
        </ul>
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
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="./local/resources/assets/img/transparent.png" alt="First slide">
                                <div class="carousel-caption">
                                    <h3 class="comment">Excelente, con todas las comodidades necesarias para sentirte como en casa.</h3>
                                    <p class="autor">Juan Francisco López</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="./local/resources/assets/img/transparent.png" alt="Second slide">
                                <div class="carousel-caption">
                                    <h3 class="comment">Una experiencia increíble. Los mejores alojamientos rurales que puedes encontrar</h3>
                                    <p class="autor">Juan Cano Ortiz</p>
                                </div>
                            </div>
                            <div class="item">
                                <img src="./local/resources/assets/img/transparent.png" alt="Third slide">
                                <div class="carousel-caption">
                                    <h3 class="comment">Sin duda alguna, la mejor calidad y precio que puedes encontrar.</h3>
                                    <p class="autor">Vicente Martínez</p>
                                </div>
                            </div>
                        </div>
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
        </div>
        <div id="push">
        </div>
    </div>
</div>
@include("include.footer")
</body>
</html>
