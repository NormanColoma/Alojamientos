<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laravel</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
    {!! Html::style('/local/resources/assets/styles/display-results.css') !!}
</head>
<body>
    @include("include.header")
    <div class="search-bar">
        <div class="container">

            <div class="inner">
                <div class="form-div form-city">
                    <span class="glyphicon glyphicon-map-marker"></span><input class="form-control " type="text" placeholder="Ciudad" name="city">
                </div>
                <div class="form-div form-date">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <input class="form-control" data-provide="datepicker" data-val="true" data-val-date="El campo Disponible desde debe ser una fecha." data-val-required="El campo Disponible desde es obligatorio." id="avialableDate" name="avialableDate" type="text" placeholder="Llegada">
                </div>
                <div class="form-div form-date">
                    <span class="glyphicon glyphicon-calendar"></span>
                    <input class="form-control " data-provide="datepicker" data-val="true" data-val-date="El campo Disponible desde debe ser una fecha." data-val-required="El campo Disponible desde es obligatorio." id="avialableDate" name="avialableDate" type="text" placeholder="Llegada">
                </div>
                <div class="form-div form-search">
                    <input type="submit" class="btn btn-primary btn-search-bar" value="Buscar">
                </div>
            </div>

        </div>
    </div>
    @foreach($users as $user)
        <li>{!! $user->name !!}</li>
    @endforeach

    <ul class="pagination">
        <li>
            <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @for($i=1;$i<=$users->total();$i++)
            <?php
                $url = "search/accommodations/".$city."/page/".$i;
            ?>
            <li><a href="{!! URL::to($url)!!}" class="page">{!! $i !!}</a></li>
        @endfor
        <li>
            <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
    <div class="container">
      <div class="sorted-bar">
          <div class="accom-number">2 resultados</div>
          <div class="accom-sort">
              <div class="dropdown">
                  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                      Filtrar por
                      <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                      <li><a href="#">Precio</a></li>
                      <li><a href="#">Populares</a></li>
                  </ul>
              </div>
          </div>
      </div>
        <ul class="accommodation-list">
            <li>
                <div class="accommodation">
                    {!! Html::image('/local/resources/assets/img/test_img/img1.jpg') !!}
                    <div class="accommodation-price">
                        <span>100 € noche</span>
                    </div>
                    <div class="accommodation-descrip">
                        <h3 class="accom-title">Anuncio </h3>
                        <p class="accom-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                            esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                    </div>
                    <div class="accommodation-details">
                        <div class="accommodation-city">
                            <span class="glyphicon glyphicon-map-marker city-icon"></span>

                            <label class="city-icon">Sevilla</label>
                            <div class="accommodation-votes">
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            </div>
                        </div>
                        <a class="btn btn-primary btn-book btn-large">Reservar</a>
                    </div>
                </div>
            </li>
            <li>
                <div class="accommodation">
                    {!! Html::image('/local/resources/assets/img/test_img/img2.jpg') !!}
                    <div class="accommodation-price">
                        <span>225 € noche</span>
                    </div>
                    <div class="accommodation-descrip">
                        <h3 class="accom-title">Anuncio </h3>
                        <p class="accom-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                            esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                    </div>
                    <div class="accommodation-details">
                        <div class="accommodation-city">
                            <span class="glyphicon glyphicon-map-marker city-icon"></span>

                            <label class="city-icon">Benidorm</label>
                            <div class="accommodation-votes">
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            </div>
                        </div>
                        <a class="btn btn-primary btn-book btn-large">Reservar</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>