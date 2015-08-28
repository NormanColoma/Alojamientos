<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/search.css">
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
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
                            <input class="form-control" data-provide="datepicker" data-val="true" data-val-date="El campo Disponible desde debe ser una fecha." data-val-required="El campo Disponible desde es obligatorio." id="avialableDate" name="avialableDate" type="text" placeholder="Llegada">
                        </div>
                        <div class='form-div date'>
                            <span class="glyphicon glyphicon-calendar"></span>
                            <input class="form-control" data-provide="datepicker" data-val="true" data-val-date="El campo Disponible desde debe ser una fecha." data-val-required="El campo Disponible desde es obligatorio." id="avialableDate" name="avialableDate" type="text" placeholder="Salida">
                        </div>
                    </li>
                    <li>
                        <div>
                            <input type="submit" class="form-control btn-primary btn-search" value="BUSCAR">
                        </div>
                    </li>
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
        <h3>Destacados</h3>
        <ul>
            <li>
                <div class="accom">
                    <img src="./local/resources/assets/img/highlights/highlights-1.jpg">
                    <div class="description">
                        <span class="city">Alicante</span>
                        <p>Aquí irá una pequeña descripción sobre el alojamiento</p>
                        <span class="price">250 €</span>
                        <span class="hidden-id" hidden="hidden">1</span>
                    </div>
                    <div class="show_details">
                        <a href="" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="accom accom-right">
                    <img src="./local/resources/assets/img/highlights/highlights-1.jpg">
                    <div class="description">
                        <span class="city">Alicante</span>
                        <p>Aquí irá una pequeña descripción sobre el alojamiento</p>
                        <span class="price">250 €</span>
                        <span class="hidden-id" hidden="hidden">1</span>
                    </div>
                    <div class="show_details">
                        <a href="" class="btn btn-sm btn-success btn-hire">Ver detalles</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="accom accom-last">
                    <img src="./local/resources/assets/img/highlights/highlights-1.jpg">
                    <div class="description">
                        <span class="city">Alicante</span>
                        <p>Aquí irá una pequeña descripción sobre el alojamiento</p>
                        <span class="price">250 €</span>
                        <span class="hidden-id" hidden="hidden">1</span>
                    </div>
                    <div class="show_details">
                        <a href="" class="btn btn-sm btn-success btn-details">Ver detalles</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
@include("include.footer")
</body>
</html>
