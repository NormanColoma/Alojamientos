<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Owner Panel</title>
        {!! Html::style('/local/resources/assets/styles/owner_panel.css') !!}
</head>
<body>
        @include("include.header")
        <div class="container">
                  <h2>Tu cuenta</h2>
                  <ul class="nav nav-tabs">
                      @if(Auth::user()->owner)
                        <li class="active"><a data-toggle="tab" href="#accoms">Mis alojamientos  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#newAccom">Añadir alojamiento  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#pers">Mis clientes <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">4</span></a></li>
                        <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @elseif(Auth::user()->admin)
                          <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">4</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @else
                          <li class="active"><a data-toggle="tab" href="#preBookings">Mis Prereservas  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#bookings">Mis Reservas  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">4</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @endif

                  </ul>

                  <div class="tab-content">
                        @if(Auth::user()->owner)
                         <div id="accoms" class="tab-pane fade in active">
                                 @include('flash::message')
                                 <h3>Alojamientos</h3>

                                 <p>Aquí se te mostrarán todos los alojamientos que hayas anunciado hasta el momento.</p>
                                 <ul>
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
                                                         <p class="accom-description">{!! $accom->getDesc() !!}</p>
                                                         <a href="#" class="btn btn-primary btn-delete-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-remove"></span> Eliminar</a>
                                                         <a href="#" class="btn btn-success btn-update-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-pencil"></span> Actualizar</a>
                                                     </div>
                                                 </div>
                                             </li>
                                         @endforeach
                                     @endif
                             </ul>
                             <script>
                                 $('#flash-overlay-modal').modal();
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
                                    <input type="text" name="new-accom-province" class="form-control new-accom-province">
                                    <span class="text-danger">{{ $errors->first('new-accom-province') }}</span>
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
                                    <span class="text-danger">{{ $errors->first('galery') }}</span>
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