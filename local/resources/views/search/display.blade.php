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
                <form method="post" action="{!! URL::to("/search/accommodations")!!}">
                    {!! csrf_field() !!}
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
                </form>
                <script>
                    $('#flash-overlay-modal').modal();
                </script>
            </div>

        </div>
    </div>


    <div class="container">
      <div class="sorted-bar">
          <div class="accom-number">
                {!! $total !!} resultados
          </div>
          <div class="accom-sort">
              <div class="dropdown">
                  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="cursor:pointer;">
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
        @if($total > 0 && $accommodations !=null)
            <ul class="accommodation-list">
                @foreach($accommodations as $accomm)
                    <?php
                    $am = new \App\Models\AccommodationModel();
                        foreach($am->allPhotos($accomm->getId()) as $photo){
                            if($photo->getMain())
                                $img = $photo->getUrl();
                        }
                    ?>
                    <li>
                        <div class="accommodation">
                            {!! Html::image('/local/resources/assets/img/accoms/'.$img ) !!}
                            <div class="accommodation-price">
                                <span>{!! round($accomm->getPrice())."€ noche" !!}</span>
                            </div>
                            <div class="accommodation-descrip">
                                <h3 class="accom-title">{!! $accomm->getTitle() !!} </h3>
                                <p class="accom-description">
                                    {!! $accomm->getDesc() !!}
                                </p>
                            </div>
                            <div class="accommodation-details">
                                <div class="accommodation-city">
                                    <span class="glyphicon glyphicon-map-marker city-icon"></span>

                                    <label class="city-icon">{!! $accomm->getCity() !!}</label>
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
                @endforeach
            </ul>
            <ul class="pagination">
                <li>
                    <a href="{!! URL::to("search/accommodations/".$city."/page/1")!!}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php
                    $per_page = 5;
                    $total = round($total/$per_page);

                ?>
                @for($i=1;$i<=$total;$i++)
                    <?php
                    $url = "search/accommodations/".$city."/page/".$i;
                    ?>
                    <li><a href="{!! URL::to($url)!!}" class="page">{!! $i !!}</a></li>
                @endfor
                <li>
                    <a href="{!! URL::to("search/accommodations/".$city."/page/".$total)!!}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        @else
            <div class="alert alert-danger">No hay resultados para la búsqueda introducida!</div>
        @endif
    </div>
</body>
</html>