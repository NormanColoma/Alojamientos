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
<div class="container container-height">
    <div class="accommodation-container">
        <div class="accommodation-main-container">
            <h2 class="accommodation-title">Alojamiento lujoso</h2>
            <h4 class="accommodation-location"><span class="glyphicon glyphicon-map-marker"></span> Elche, Alicante</h4>
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
                                        <div class="active item" data-slide-number="0">
                                            <img src="http://placehold.it/770x300&text=one"></div>

                                        <div class="item" data-slide-number="1">
                                            <img src="http://placehold.it/770x300&text=two"></div>

                                        <div class="item" data-slide-number="2">
                                            <img src="http://placehold.it/770x300&text=three"></div>

                                        <div class="item" data-slide-number="3">
                                            <img src="http://placehold.it/770x300&text=four"></div>

                                        <div class="item" data-slide-number="4">
                                            <img src="http://placehold.it/770x300&text=five"></div>

                                        <div class="item" data-slide-number="5">
                                            <img src="http://placehold.it/770x300&text=six"></div>
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

                            <div id="slide-content" style="display: none;">
                                <div id="slide-content-0">
                                    <h2>Slider One</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>

                                <div id="slide-content-1">
                                    <h2>Slider Two</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>

                                <div id="slide-content-2">
                                    <h2>Slider Three</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>

                                <div id="slide-content-3">
                                    <h2>Slider Four</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>

                                <div id="slide-content-4">
                                    <h2>Slider Five</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>

                                <div id="slide-content-5">
                                    <h2>Slider Six</h2>
                                    <p>Lorem Ipsum Dolor</p>
                                    <p class="sub-text">October 24 2014 - <a href="#">Read more</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/Slider-->

                <div class="row hidden-xs" id="slider-thumbs">
                    <!-- Bottom switcher of slider -->
                    <ul class="hide-bullets">
                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-0"><img src="http://placehold.it/170x100&text=one"></a>
                        </li>

                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-1"><img src="http://placehold.it/170x100&text=two"></a>
                        </li>

                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-2"><img src="http://placehold.it/170x100&text=three"></a>
                        </li>

                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-3"><img src="http://placehold.it/170x100&text=four"></a>
                        </li>

                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-4"><img src="http://placehold.it/170x100&text=five"></a>
                        </li>

                        <li class="col-sm-2">
                            <a class="thumbnail" id="carousel-selector-5"><img src="http://placehold.it/170x100&text=six"></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="accommodation-about">
                <ul>
                    <li>
                        <h3 class="accommodation-about-info">Detalles del alojamiento</h3>
                        <ul class="accommodation-about-info-list">
                            <li>4 habitaciones</li>
                            <li>2 baños</li>
                            <li>Máximo 8 personas</li>
                            <li>
                                <h4>Interior</h4>
                                <p>El interior de la casa está muy bien amueblado posee todas las necesidades.</p>
                            </li>
                            <li>
                                <h4>Exterior</h4>
                                <p>El exterior de la casa tiene unas vistas preciosas. Además tiene una piscina perfecta.</p>
                            </li>
                        </ul>
                    </li>
                    <li><h3 class="accommodation-about-info">Descripción</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                            sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                            veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                            irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
                            sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    </li>
                    <li><h3 class="accommodation-about-info">Precio y condiciones</h3>
                        <ul class="accommodation-about-info-list">
                            <li>
                                <h4>Precio</h4>
                                <p>Precio por noche <span>150 €</span></p>
                            </li>
                            <li>
                                <h4>Condiciones</h4>
                                <p>Las condiciones deben ser discutidas con el propietario del alojamiento. Para ello, ponte en contacto con él, o realiza
                                una prereserva para que te él pueda informarte de las mismas.</p>
                            </li>
                        </ul>
                    </li>
                    <li><h3 class="accommodation-about-info">Comentarios y valoración</h3>
                    </li>
                </ul>
            </div>
        </div>
        <div class="accommodation-right-bar-side-container">
            <form>
                <div class="form-group">

                </div>
            </form>
        </div>
    </div>
</div>
@include("include.footer")
</body>
</html>