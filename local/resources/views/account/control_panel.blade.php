<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Control Panel</title>
        {!! Html::style('/local/resources/assets/styles/owner_panel.css') !!}
</head>
<body>
        @include("include.header")
        <div class="container">
                  <h2>Tu cuenta</h2>
                  <ul class="nav nav-tabs">
                      @if(Auth::user()->owner)
                        <li class="active"><a data-toggle="tab" href="#accoms" id="btn-display-accoms">Mis alojamientos  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#newAccom" id="btn-add-accom">Añadir alojamiento  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#pers">Mis clientes <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">0</span></a></li>
                        <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @elseif(Auth::user()->admin)
                          <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">0</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @else
                          <li class="active"><a data-toggle="tab" href="#preBookings">Mis Prereservas  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#bookings">Mis Reservas  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">0</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @endif

                  </ul>

                  <div class="tab-content">
                        @if(Auth::user()->owner)
                         <div id="accoms" class="tab-pane fade in active">
                                 @include('flash::message')
                                 <h3 id="accomms">Alojamientos</h3>

                                 <p>Aquí se te mostrarán todos los alojamientos que hayas anunciado hasta el momento.</p>
                                 <ul class="accom-list">
                                     @if(count($accommodations) > 0)
                                         @foreach($accommodations as $accom)
                                             @foreach($accom->getPhotos() as $photo)
                                                 @if($photo->getMain())
                                                     <?php $img = $photo->getUrl() ?>
                                                 @endif
                                             @endforeach
                                             <li>
                                                 <div class="accomodation">
                                                     {!! Html::image('/local/resources/assets/img/accoms/' . $img) !!}
                                                     <div class="accom-descrip">
                                                         <h3 class="accom-title">{!! $accom->getTitle() !!}</h3>
                                                         <p class="accom-description">{!! $accom->getInitialDesc() !!}</p>
                                                         <a href="#" class="btn btn-primary btn-delete-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-remove"></span> Eliminar</a>
                                                         <a href="#" class="btn btn-success btn-update-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-pencil"></span> Actualizar</a>
                                                     </div>
                                                 </div>
                                             </li>
                                         @endforeach
                                     @endif
                             </ul>
                             <?php
                                 $per_page = 5;
                                 $total = ceil(count($accommodations)/$per_page);
                             ?>
                             <ul class="pagination pagination-accom">
                                 <li>
                                     <a style="cursor:pointer;" aria-label="Previous" name="1">
                                         <span aria-hidden="true">&laquo;</span>
                                     </a>
                                 </li>
                                 @for($i=1;$i<=$total;$i++)
                                     <li><a style="cursor:pointer;" name="{!! $i !!}">{!! $i !!}</a></li>
                                 @endfor
                                 <li>
                                     <a style="cursor:pointer;" aria-label="Next" name="{!! $total !!}">
                                         <span aria-hidden="true">&raquo;</span>
                                     </a>
                                 </li>
                             </ul>
                             <script>
                                 $('#flash-overlay-modal').modal();
                                 $(document).ready(function(){
                                     var items = $(".accom-list li").length;
                                     var page=1;
                                     var page_items = 1;
                                     var per_page = 5;
                                     $(".accom-list li").each(function(){
                                         $(this).attr("id","accom-page-"+page);
                                         if(page_items==per_page) {
                                             page++;
                                             page_items = per_page;
                                         }
                                         page_items++;
                                     })

                                     displayPage(1);
                                     $(".pagination-accom a").click(function(){
                                         var page = $(this).attr("name");
                                         displayPage(page);
                                     })

                                 })

                                 function displayPage(page){
                                     $(".accom-list li").each(function(){
                                         if($(this).attr("id") != "accom-page-"+page){
                                             $(this).hide();
                                         }
                                         else
                                            $(this).show();
                                     })
                                     $('html, body').animate({ scrollTop: 0 }, 0);

                                 }
                             </script>

                        </div>
                        <div id="pers" class="tab-pane fade">
                                <h3>Clientes</h3>
                        </div>
                        @endif
                        @if(!Auth::user()->owner && !Auth::user()->admin)
                                <div id="preBookings" class="tab-pane fade active in">
                                    <h3>Prereservas realizadas</h3>
                                </div>
                                <div id="bookings" class="tab-pane fade">
                                    <h3>Reservas realizadas</h3>
                                </div>
                            @endif
                        <div id="messages" class="tab-pane fade">
                                <h3>Mensajes</h3>
                        </div>
                        <div id="account" class="tab-pane fade">
                                <h3>Configuración de la cuenta</h3>
                        </div>
                            @if(Auth::user()->owner)
                        <div id="newAccom" class="tab-pane fade">
                            <h3>Nuevo Alojamiento</h3>
                            {!! Form::open(['url' => 'accommodation/publish', 'files' => true]) !!}
                            <div class="form-group form-default">
                                <label>Título del anuncio</label>
                                <input type="text" name="new-accom-title" class="form-control">
                                <span class="text-danger">{{ $errors->first('new-accom-title') }}</span>
                            </div>
                            <div class="row">
                                <div class="form-group form-default col-xs-6">
                                    <label>Ciudad</label>
                                    <input type="text" name="new-accom-city" class="form-control new-accom-city">
                                    <span class="text-danger">{{ $errors->first('new-accom-city') }}</span>
                                </div>
                                <div class="form-group form-default col-xs-6">
                                    <label>Provincia</label>
                                    <select name="new-accom-province" class="form-control new-accom-province">
                                        <option value='álava'>Álava</option>
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
                                <input type="text" name="new-accom-price" class="form-control">
                                <span class="text-danger">{{ $errors->first('new-accom-price') }}</span>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-4">
                                    <label>Nº de habitaciones</label>
                                    <select name="new-accom-beds" class="form-control">
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
                                    <textarea class="form-control" placeholder="Introduce una breve descripción del interior del alojamiento. Este campo no es obligatorio" name="new-accom-inside"></textarea>
                                    <span class="text-danger">{{ $errors->first('new-accom-inside') }}</span>
                                    </div>
                                <div class="form-group form-default col-xs-6">
                                    <label>Exterior</label>
                                    <textarea class="form-control" placeholder="Introduce una breve descripción del exterior del alojamiento. Este campo no es obligatorio" name="new-accom-outside"></textarea>
                                    <span class="text-danger">{{ $errors->first('new-accom-outside') }}</span>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label>Descripción del anuncio</label>
                                <textarea class="form-control form-desc" name="new-accom-desc"></textarea>
                                <span class="text-danger">{{ $errors->first('new-accom-desc') }}</span>
                            </div>
                            <div class="row">

                                <div class="col-lg-6 col-sm-6 col-12">
                                    <label>Selecciona la imagen princiapl</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                Principal&hellip; <input type="file" name="new-accom-main-img">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <span>La imagen no puede pesar más de 5mb</span>
                                    <span class="text-danger">{{ $errors->first('new-accom-main-img') }}</span>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-12">
                                    <label>Selecciona las imágenes de la galería</label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-primary btn-file">
                                                Galería&hellip; <input type="file" multiple name="galery[]">
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly>
                                    </div>
                                    <span>Solo puedes subir un máximo de 6 imágenes (5mb máximo por imagen)</span>
                                    <span class="text-danger" style="float:left;">{{ $errors->first('galery') }}</span>
                            </div>
                            </div>
                            <div class="form-group form-submit">
                                <input type="submit" class="btn btn-primary" value="Anunciar">
                            </div>

                            {!! Form::close() !!}
                            <script>
                                var url = document.location.toString();
                                if (url.match('#')) {
                                    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
                                }
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
                                @endif
                </div>
        </div>
</body>
</html>