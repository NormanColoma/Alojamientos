<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <title>Control Panel</title>
        {!! Html::style('/local/resources/assets/styles/owner_panel.css') !!}
        {!! Html::style('/local/resources/assets/styles/mails.css') !!}
        <meta name="csrf-token" content="<?= csrf_token() ?>">
</head>
<body>
        @include("include.header")
        <div class="container container-height">
            @include('flash::message')
                  <h2>Tu cuenta</h2>
                  <ul class="nav nav-tabs">
                      <?php
                          $unread =0;
                          if(count($incoming)>0){
                              foreach($incoming as $message){
                                  if(!$message->isRead())
                                      $unread++;
                              }
                          }

                      ?>
                      @if(Auth::user()->owner)
                        <li class="active"><a data-toggle="tab" href="#accoms" id="btn-display-accoms">Mis alojamientos  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#newAccom" id="btn-add-accom">Añadir alojamiento  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                              <li><a data-toggle="tab" href="#preBookings" class="prebookings">Prereservas  <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
                              <li><a data-toggle="tab" href="#bookings" class="bookings">Reservas<span class="glyphicon glyphicon-book" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#pers">Mis clientes <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
                        <li><a data-toggle="tab" href="#messages" class="messages">Bandeja de entrada <span class="badge">{!! $unread !!}</span></a></li>
                        <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @elseif(Auth::user()->admin)
                          <li><a data-toggle="tab" href="#messages" class="messages">Bandeja de entrada <span class="badge">{!! $unread !!}</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @else
                          <li class="active"><a data-toggle="tab" href="#preBookings" class="prebookings">Mis Prereservas  <span class="glyphicon glyphicon-book" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#bookings" class="bookings">Mis Reservas  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                          <li><a data-toggle="tab" href="#messages" class="messages">Bandeja de entrada <span class="badge">{!! $unread !!}</span></a></li>
                          <li><a data-toggle="tab" href="#account">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                          @endif

                  </ul>

                  <div class="tab-content">
                        @if(Auth::user()->owner)
                         <div id="accoms" class="tab-pane fade in active">
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
                                                 <div class="accomodation" id="accommodation-{!! $accom->getId() !!}">
                                                     {!! Html::image('/local/resources/assets/img/accoms/' . $img) !!}
                                                     <div class="accom-descrip">
                                                         <h3 class="accom-title">{!! $accom->getTitle() !!}</h3>
                                                         <p class="accom-description">{!! $accom->getInitialDesc() !!}</p>
                                                         <a class="btn btn-danger btn-delete-accom" id="{!! $accom->getID() !!}"><span class="glyphicon glyphicon-remove"></span> Eliminar</a>
                                                         <a href="{!! URL::to("accommodation/".$accom->getID() . "/update") !!}" class="btn btn-success btn-update-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-pencil"></span> Actualizar</a>
                                                         <a href="{!! URL::to("accommodation/".$accom->getID() . "/schedule/update") !!}" class="btn btn-grey btn-schedule-accom" id={!! $accom->getID() !!}><span class="glyphicon glyphicon-calendar"></span> Calendario ocupación</a>
                                                     </div>
                                                 </div>
                                             </li>
                                         @endforeach
                                     @endif
                             </ul>
                             <div id="deleteModal" class="modal fade" role="dialog">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                             <h4 class="modal-title">Eliminado</h4>
                                         </div>
                                         <div class="modal-body">
                                             <p>El alojamiento ha sido eliminado con éxito.</p>
                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                         </div>
                                     </div>

                                 </div>
                             </div>
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

                                     $(".btn-delete-accom").click(function(){
                                         var id = $(this).attr("id");
                                         deleteAccomm(id);
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

                                 function deleteAccomm(id){
                                     var port = location.port;
                                     var uri = "http://localhost:" + port + "/alojamientos/accommodation/delete/"+id;
                                     $.ajax({
                                         type: "Delete",
                                         url: uri,
                                         success: function(data) {
                                             if(data.ok)
                                               removeAccomFromDOM(id);
                                         }, error: function(){
                                             alert("bad")
                                         }
                                     });
                                 }

                                 function removeAccomFromDOM(id){
                                     $("#deleteModal").modal('show');
                                     $("#accommodation-"+id).remove();
                                 }

                                 $(function() {
                                     $.ajaxSetup({
                                         headers: {
                                             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                                         }
                                     });
                                 });
                             </script>

                        </div>
                        <div id="pers" class="tab-pane fade">
                                <h3>Clientes</h3>
                        </div>
                          <div id="preBookings" class="tab-pane fade">
                              <h3 class="prebooking-title">Prereservas realizadas por los usuarios en sus alojamientos</h3>
                              <p class="prebooking-options-info">Pulse sobre "Enviar condiciones" para poder verificar primero los datos de la prereserva en cuestión</p>
                              @if(count($prebookings) > 0)
                                  <ul class="prebooking-list">
                                      @foreach($prebookings as $pb)
                                          <li>
                                              <div class="prebooking-header">
                                                  <span>Prereserva para el <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$pb->getAccommId()."/details") !!}">alojamiento</a> con id {!! $pb->getAccommId()!!}</span>
                                                  <div class="prebooking-options">
                                                      <a class="btn btn-xs btn-success btn-send-conditions" id="{!! $pb->getId() !!}">Enviar condiciones</a>
                                                      <a class="btn btn-xs btn-danger btn-delete-prebooking" id="{!! $pb->getId() !!}">Eliminar</a>
                                                  </div>
                                              </div>
                                          </li>
                                      @endforeach
                                  </ul>
                                  <div class="alert alert-success prebooking-deleted">
                                      <strong>Preserva eliminada!</strong> La prereserva ha sido eliminada correctemte.
                                  </div>
                                  <div class="alert alert-danger prebooking-not-found">
                                      <strong>Error!</strong> La prereserva no se encuentra disponible, o ya ha sido eliminada por el usuario que la realizó.
                                  </div>
                                  <div id="conditions">
                                      {!! Form::open(['id'=> "conditions-message-form"]) !!}
                                      <div class="form-group booking-info">
                                          <h4>Información de la prereserva</h4>
                                          <ul>
                                              <li class="prebooking-id"></li>
                                              <li class="prebooking-date"></li>
                                              <li class="prebooking-persons"></li>
                                              <li class="prebooking-price"></li>
                                          </ul>
                                      </div>
                                      <div class="form-group booking-dates">
                                          <h4>Fechas de reserva solicitadas</h4>
                                          <p>Fechas de reserva solicitadas por el usuario para ocupar el alojamiento</p>
                                          <ul>
                                              <li class="prebooking-cin"></li>
                                              <li class="prebooking-cout"></li>
                                          </ul>
                                      </div>
                                      <div class="form-group booking-user">
                                          <h4>Detalles del usuario</h4>
                                          <p>Detalles del usuario que realizó la prereserva a través de AlojaRural</p>
                                          <ul>
                                              <li class="prebooking-user"></li>
                                              <li class="prebooking-user-email"></li>
                                              <li class="prebooking-user-phone"></li>
                                          </ul>
                                      </div>
                                      <p class="message-to"></p>
                                      <div class="form-group">
                                          <textarea placeholder="Escribe aquí cuales serán las condiciones de la reserva" name="text-conditions"></textarea>
                                      </div>
                                      <input type="hidden" name="from" class="h-from">
                                      <input type="hidden" name="to" class="h-to">
                                      <input type="hidden" name="user_name" class="h-user">
                                      <input type="button" value="Enviar condiciones" class="btn btn-success btn-send-conditions-up">
                                      <input type="button" value="Ver prereservas" class="btn btn-grey btn-back-prebookings">
                                      {!! Form::close() !!}
                                  </div>

                              @endif
                          </div>
                          <div id="bookings" class="tab-pane fade">
                              <h3 class="booking-title">Reservas realizadas por los usuarios en sus alojamientos</h3>
                              <p class="booking-options-info">Pulse sobre "Ver Detalles" para poder verificar los detalles de la reserva en cuestión</p>
                              @if(count($bookings) > 0)
                                  <ul class="booking-list">
                                      @foreach($bookings as $b)
                                          <li>
                                              <div class="booking-header">
                                                  <span>Reserva para el <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$b->getAccommId()."/details") !!}">alojamiento</a></span>
                                                  <div class="booking-options">
                                                      <a class="btn btn-xs btn-success btn-show-booking-details" id="{!! $b->getId() !!}">Ver detalles</a>
                                                      <a class="btn btn-xs btn-danger" id="{!! $b->getId() !!}">Eliminar</a>
                                                  </div>
                                              </div>
                                          </li>
                                      @endforeach
                                  </ul>
                                  <div class="alert alert-success prebooking-deleted">
                                      <strong>Preserva eliminada!</strong> La Rereserva ha sido eliminada correctemte.
                                  </div>
                                  <div class="alert alert-danger prebooking-not-found">
                                      <strong>Error!</strong> La Reserva no se encuentra disponible, o ya ha sido eliminada.
                                  </div>
                                  <div id="booking-details">
                                      <div class="form-group booking-info">
                                          <h4>Información de la Reserva</h4>
                                          <ul>
                                              <li class="booking-id"></li>
                                              <li class="booking-date"></li>
                                              <li class="booking-persons"></li>
                                              <li class="booking-price"></li>
                                          </ul>
                                      </div>
                                      <div class="form-group booking-dates">
                                          <h4>Fechas de reserva</h4>
                                          <p>Fechas de reserva solicitadas para ocupar el alojamiento</p>
                                          <ul>
                                              <li class="booking-cin"></li>
                                              <li class="booking-cout"></li>
                                          </ul>
                                      </div>
                                      <div class="form-group booking-user">
                                          <h4>Detalles del propietario</h4>
                                          <p>Detalles del propietario del alojamiento</p>
                                          <ul>
                                              <li class="booking-owner-name"></li>
                                              <li class="booking-owner-email"></li>
                                              <li class="booking-owner-phone"></li>
                                          </ul>
                                      </div>
                                      <input type="button" value="Ver Reservas" class="btn btn-grey btn-back-bookings">
                                  </div>
                              @endif
                          </div>
                          <script>
                              $(document).ready(function(){
                                  $(".btn-send-conditions").click(function(){
                                      var id = $(this).attr("id");
                                      getBooking(id);

                                  })

                                  $(".btn-show-booking-details").click(function(){
                                      var id = $(this).attr("id");
                                      showBooking(id);

                                  })


                                  $(".btn-delete-prebooking").click(function (){
                                      var id = $(this).attr("id");
                                      deleteBooking(id);

                                  })

                                  $(".btn-back-prebookings, .prebookings").click(function(){
                                      $(".prebooking-title").text("Prereservas realizadas por los usuarios en sus alojamientos");
                                      $(".prebooking-options-info").text('Pulse sobre "Enviar condiciones" para poder verificar primero los datos de la prereserva en cuestión');
                                      $("#conditions").hide();
                                      $(".prebooking-list").show();
                                  })

                                  $(".btn-back-bookings, .bookings").click(function(){
                                      $(".booking-title").text("Reservas realizadas en AlojaRural");
                                      $(".booking-options-info").text('Desde aquí podrás ver los detalles de tus reservas');
                                      $("#booking-details").hide();
                                      $(".booking-list").show();
                                  })

                                  $(".btn-send-conditions-up").click(function(){
                                      var id = $(".btn-send-conditions").attr("id");
                                      var port = location.port;
                                      var uri = "http://localhost:" + port + "/alojamientos/booking/"+id+"/send";
                                      $('#conditions-message-form').attr('action', uri).submit();
                                  })

                                  function getBooking(id){
                                      var port = location.port;
                                      var uri = "http://localhost:" + port + "/alojamientos/prebooking/"+id+"/show";
                                      $.ajax({
                                          type: "Get",
                                          url: uri,
                                          success: function(data) {
                                              $(".prebooking-title").text("Detalles de la Prereserva");
                                              $(".prebooking-options-info").text("A continuación podrá ver los detalles de la prereserva solicitada por el usuario");
                                              $(".prebooking-cin").text("LLegada: "+data.check_in);
                                              $(".prebooking-cout").text("Salida: "+data.check_out);
                                              $(".prebooking-persons").text("Número de personas para la reserva: "+data.persons);
                                              $(".prebooking-user").text(data.traveler_name);
                                              $(".prebooking-id").text("Identificador de la reserva: "+data.id);
                                              $(".prebooking-price").text("Precio estimado por AlojaRural bajo las condiciones de la reserva: "+data.price+"€");
                                              $(".prebooking-date").text("La reserva fue realizada: "+data.date);
                                              $(".h-user").val(data.traveler_name);
                                              $(".prebooking-user-email").text(data.traveler_email);
                                              $(".h-to").val(data.traveler_email);
                                              $(".h-from").val(data.owner_email);
                                              $(".prebooking-user-phone").text(data.traveler_phone);
                                              $(".prebooking-list").hide();
                                              $("#conditions").show();
                                          }, error: function(){
                                              $("#"+id).closest("li").remove();
                                              $(".prebooking-not-found").show();
                                              $(".alert").delay(3000).slideUp(200);

                                          }
                                      });
                                  }
                              })

                              function showBooking(id){
                                  var port = location.port;
                                  var uri = "http://localhost:" + port + "/alojamientos/booking/"+id+"/show";
                                  $.ajax({
                                      type: "Get",
                                      url: uri,
                                      success: function(data) {
                                          $(".booking-title").text("Detalles de la Reserva");
                                          $(".booking-options-info").text("A continuación podrá ver los detalles de la Reserva solicitada por el usuario");
                                          $(".booking-cin").text("LLegada: "+data.check_in);
                                          $(".booking-cout").text("Salida: "+data.check_out);
                                          $(".booking-persons").text("Número de personas para la reserva: "+data.persons);
                                          $(".booking-id").text("Identificador de la reserva: "+data.id);
                                          $(".booking-price").text("Precio final establecido: "+data.price+"€");
                                          $(".booking-date").text("La reserva fue realizada: "+data.date);
                                          $(".booking-owner-email").text(data.traveler_email);
                                          $(".booking-owner-phone").text(data.traveler_phone);
                                          $(".booking-owner-name").text(data.traveler_phone);
                                          $(".booking-list").hide();
                                          $("#booking-details").show();
                                      }, error: function(){
                                          $("#"+id).closest("li").remove();
                                          $(".prebooking-not-found").show();
                                          $(".alert").delay(3000).slideUp(200);

                                      }
                                  });
                              }

                              function deleteBooking(id){
                                  var port = location.port;
                                  var uri = "http://localhost:" + port + "/alojamientos/prebooking/"+id+"/delete";
                                  $.ajax({
                                      type: "Delete",
                                      url: uri,
                                      success: function(data) {
                                          $("#"+id).closest("li").remove();
                                          $(".prebooking-deleted").show();
                                          $(".alert").delay(3000).slideUp(200);
                                      }, error: function(){
                                          $("#"+id).closest("li").remove();
                                          $(".prebooking-not-found").show();
                                          $(".alert").delay(3000).slideUp(200);
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
                          </script>
                        @endif
                        @if(!Auth::user()->owner && !Auth::user()->admin)
                                <div id="preBookings" class="tab-pane fade active in">
                                    <h3 class="prebooking-user-title">Tus prereservas realizadas (una vez que las confirmes pasarán a reservas)</h3>
                                    <p class="prebooking-user-options-info">Elimine o vea los detalles de sus prereservas</p>
                                    @if(count($prebookings) > 0)
                                        <ul class="prebooking-user-list">
                                            @foreach($prebookings as $pb)
                                                <li>
                                                    <div class="prebooking-header">
                                                        <span>Prereserva para el <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$pb->getAccommId()."/details") !!}">alojamiento</a> con id {!! $pb->getAccommId()!!}</span>
                                                        <div class="prebooking-options">
                                                            <a class="btn btn-xs btn-success btn-show-details" id="{!! $pb->getId() !!}">Ver detalles</a>
                                                            <a class="btn btn-xs btn-danger btn-delete-prebooking" id="{!! $pb->getId() !!}">Eliminar</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="alert alert-success prebooking-deleted">
                                            <strong>Preserva eliminada!</strong> La prereserva ha sido eliminada correctemte.
                                        </div>
                                        <div class="alert alert-danger prebooking-not-found">
                                            <strong>Error!</strong> La prereserva no se encuentra disponible, o ya ha sido eliminada por el propietario del alojamiento.
                                        </div>
                                    @endif
                                    <div id="details">
                                        <div class="form-group booking-info">
                                            <h4>Información de la prereserva</h4>
                                            <ul>
                                                <li class="prebooking-id"></li>
                                                <li class="prebooking-date"></li>
                                                <li class="prebooking-persons"></li>
                                                <li class="prebooking-price"></li>
                                            </ul>
                                        </div>
                                        <div class="form-group booking-dates">
                                            <h4>Fechas de reserva</h4>
                                            <p>Fechas de reserva solicitadas para ocupar el alojamiento</p>
                                            <ul>
                                                <li class="prebooking-cin"></li>
                                                <li class="prebooking-cout"></li>
                                            </ul>
                                        </div>
                                        <div class="form-group booking-user">
                                            <h4>Detalles del propietario</h4>
                                            <p>Detalles del propietario del alojamiento</p>
                                            <ul>
                                                <li class="prebooking-owner-name"></li>
                                                <li class="prebooking-owner-email"></li>
                                                <li class="prebooking-owner-phone"></li>
                                            </ul>
                                        </div>
                                        <input type="button" value="Ver prereservas" class="btn btn-grey btn-back-prebookings">
                                    </div>
                                </div>
                                <div id="bookings" class="tab-pane fade">
                                    <h3 class="booking-user-title">Reservas realizadas en AlojaRural</h3>
                                    <p class="booking-user-options-info">Desde aquí podrás ver los detalles de tus reservas</p>
                                    @if(count($bookings) > 0)
                                        <ul class="booking-user-list">
                                            @foreach($bookings as $b)
                                                <li>
                                                    <div class="booking-header">
                                                        <span>Reserva confirmada para el <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$b->getAccommId()."/details") !!}">alojamiento</a>. Pinchando en "Ver detalles" verá los detalles de la misma.</span>
                                                        <div class="booking-options">
                                                            <a class="btn btn-xs btn-success btn-show-booking-details" id="{!! $b->getId() !!}">Ver detalles</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="alert alert-danger booking-not-found">
                                            <strong>Error!</strong> La reserva no se encuentra disponible, o ya ha sido eliminada por el propietario del alojamiento.
                                        </div>
                                    @endif
                                    <div id="booking-details">
                                        <div class="form-group booking-info">
                                            <h4>Información de la Reserva</h4>
                                            <ul>
                                                <li class="booking-id"></li>
                                                <li class="booking-date"></li>
                                                <li class="booking-persons"></li>
                                                <li class="booking-price"></li>
                                            </ul>
                                        </div>
                                        <div class="form-group booking-dates">
                                            <h4>Fechas de reserva</h4>
                                            <p>Fechas de reserva solicitadas para ocupar el alojamiento</p>
                                            <ul>
                                                <li class="booking-cin"></li>
                                                <li class="booking-cout"></li>
                                            </ul>
                                        </div>
                                        <div class="form-group booking-user">
                                            <h4>Detalles del propietario</h4>
                                            <p>Detalles del propietario del alojamiento</p>
                                            <ul>
                                                <li class="booking-owner-name"></li>
                                                <li class="booking-owner-email"></li>
                                                <li class="booking-owner-phone"></li>
                                            </ul>
                                        </div>
                                        <input type="button" value="Ver Reservas" class="btn btn-grey btn-back-bookings">
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $(".btn-show-details").click(function(){
                                            var id = $(this).attr("id");
                                            getBooking(id);

                                        })

                                        $(".btn-show-booking-details").click(function(){
                                            var id = $(this).attr("id");
                                            showBooking(id);

                                        })

                                        $(".btn-back-prebookings, .prebookings").click(function(){
                                            $(".prebooking-user-title").text("Tus prereservas realizadas (una vez que las confirmes pasarán a reservas)");
                                            $(".prebooking-user-options-info").text('Elimine o vea los detalles de sus prereservas');
                                            $("#details").hide();
                                            $(".prebooking-user-list").show();
                                        })

                                        $(".btn-back-bookings, .bookings").click(function(){
                                            $(".booking-user-title").text("Reservas realizadas en AlojaRural");
                                            $(".booking-user-options-info").text('Desde aquí podrás ver los detalles de tus reservas');
                                            $("#booking-details").hide();
                                            $(".booking-user-list").show();
                                        })

                                        $(".btn-delete-prebooking").click(function (){
                                            var id = $(this).attr("id");
                                            deleteBooking(id);

                                        })


                                        function deleteBooking(id){
                                            var port = location.port;
                                            var uri = "http://localhost:" + port + "/alojamientos/prebooking/"+id+"/delete";
                                            $.ajax({
                                                type: "Delete",
                                                url: uri,
                                                success: function(data) {
                                                    $("#"+id).closest("li").remove();
                                                    $(".prebooking-deleted").show();
                                                    $(".alert").delay(3000).slideUp(200);
                                                }, error: function(){
                                                    $("#"+id).closest("li").remove();
                                                    $(".prebooking-not-found").show();
                                                    $(".alert").delay(3000).slideUp(200);
                                                }
                                            });
                                        }

                                        function getBooking(id){
                                            var port = location.port;
                                            var uri = "http://localhost:" + port + "/alojamientos/prebooking/"+id+"/show";
                                            $.ajax({
                                                type: "Get",
                                                url: uri,
                                                success: function(data) {
                                                    $(".prebooking-user-title").text("Detalles de la Prereserva");
                                                    $(".prebooking-user-options-info").text("A continuación podrá ver los detalles de la prereserva solicitada");
                                                    $(".prebooking-cin").text("LLegada: "+data.check_in);
                                                    $(".prebooking-cout").text("Salida: "+data.check_out);
                                                    $(".prebooking-persons").text("Número de personas para la reserva: "+data.persons);
                                                    $(".prebooking-id").text("Identificador de la reserva: "+data.id);
                                                    $(".prebooking-price").text("Precio estimado por AlojaRural: "+data.price+"€ (Le recordamos que este precio puede variar en función de las condiciones establecias por el propietario)");
                                                    $(".prebooking-date").text("La reserva fue realizada: "+data.date);
                                                    $(".prebooking-owner-email").text(data.owner_email);
                                                    $(".prebooking-owner-phone").text(data.owner_phone);
                                                    $(".prebooking-owner-name").text(data.owner_name);
                                                    $(".prebooking-user-list").hide();
                                                    $("#details").show();
                                                }, error: function(){
                                                    $("#"+id).closest("li").remove();
                                                    $(".prebooking-not-found").show();
                                                    $(".alert").delay(3000).slideUp(200);

                                                }
                                            });
                                        }


                                        function showBooking(id){
                                            var port = location.port;
                                            var uri = "http://localhost:" + port + "/alojamientos/booking/"+id+"/show";
                                            $.ajax({
                                                type: "Get",
                                                url: uri,
                                                success: function(data) {
                                                    $(".booking-user-title").text("Detalles de la Reserva");
                                                    $(".booking-user-options-info").text("A continuación podrá ver los detalles de la Reserva solicitada");
                                                    $(".booking-cin").text("LLegada: "+data.check_in);
                                                    $(".booking-cout").text("Salida: "+data.check_out);
                                                    $(".booking-persons").text("Número de personas para la reserva: "+data.persons);
                                                    $(".booking-id").text("Identificador de la reserva: "+data.id);
                                                    $(".booking-price").text("Precio establecido por el propietario: "+data.price+"€");
                                                    $(".booking-date").text("La reserva fue realizada: "+data.date);
                                                    $(".booking-owner-email").text(data.owner_email);
                                                    $(".booking-owner-phone").text(data.owner_phone);
                                                    $(".booking-owner-name").text(data.owner_phone);
                                                    $(".booking-user-list").hide();
                                                    $("#booking-details").show();
                                                }, error: function(){
                                                    $("#"+id).closest("li").remove();
                                                    $(".prebooking-not-found").show();
                                                    $(".alert").delay(3000).slideUp(200);

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
                            @endif
                        <div id="messages" class="tab-pane fade">
                                <h3 class="message-title">Mensajes</h3>
                                <div id="recieved">
                                    <ul class="message-list">
                                        @if(count($incoming)>0)
                                            @foreach($incoming as $m)
                                                @if(!$m->isRead())
                                                    <li id="{!! $m->getId() !!}" class="unread">
                                                        <div>
                                                            <input type="checkbox"><span class="autor">{!! $m->getFrom()!!}</span><span>{!! $m->getSubject() !!}</span>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li id="{!! $m->getId() !!}">
                                                        <div>
                                                            <input type="checkbox"><span class="autor">{!! $m->getFrom()!!}</span><span>{!! $m->getSubject() !!}</span>
                                                        </div>
                                                    </li>
                                                @endif
                                            @endforeach
                                        @else
                                         <p>Todavía no has recivido ningún mensaje</p>
                                        @endif
                                    </ul>
                                    <div class="form-group message-buttons">
                                        <button type="button" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-trash"></span>&nbsp;
                                        </button>
                                        <button type="button" class="btn btn-success">
                                            <span class="glyphicon glyphicon-pencil"></span>&nbsp;
                                        </button>
                                    </div>
                                </div>
                                <div id="showMessage">
                                    <h4 class="message-subject"></h4>
                                    <div class="message-text">
                                    </div>
                                    <ul class="in-message-options">
                                        <li><a class="new-message">Responder</a></li>
                                        <li><a class="delete-message">Eliminar</a></li>
                                        <li><a class="show-messages">Bandeja de entrada</a></li>
                                    </ul>
                                    <div id="newMessage">
                                        {!! Form::open(['url' => 'user/update/' . Auth::user()->id, 'id' => 'normal-message-form']) !!}
                                        <p class="message-to"></p>
                                        <div class="form-group">
                                            <textarea placeholder="Escribe aquí tu mensaje" name="text-message"></textarea>
                                        </div>
                                        <input type="submit" value="Enviar" class="btn btn-success btn-send-message">
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function(){
                                        $(".message-list li").click(function(){
                                            $("#recieved").hide();
                                            var id = $(this).attr("id");
                                            readMessage(id);
                                        })

                                        $(".show-messages, .messages").click(function(){
                                            $("#showMessage").hide();
                                            $("#newMessage").hide();
                                            $(".message-title").text("Mensajes")
                                            $("#recieved").show();
                                        })

                                        $(".new-message").click(function(){
                                                $(".message-title").text("Nuevo mensaje")
                                                $("#newMessage").show();
                                        })

                                        function readMessage(id){
                                            var port = location.port;
                                            var uri = "http://localhost:" + port + "/alojamientos/message/read/"+id;
                                            $.ajax({
                                                type: "Post",
                                                url: uri,
                                                success: function(data) {
                                                    $("#"+id).toggleClass("unread");
                                                    var total_m = $(".badge").text();
                                                    total_m = parseInt(total_m) - 1;
                                                    if(total_m >= 0)
                                                        $(".badge").text(total_m);
                                                    getMessage(id);
                                                }, error: function(){
                                                    getMessage(id);
                                                }
                                            });
                                        }

                                        function getMessage(id){
                                            var port = location.port;
                                            var uri = "http://localhost:" + port + "/alojamientos/message/"+id+"/show";
                                            $.ajax({
                                                type: "get",
                                                url: uri,
                                                success: function(data) {
                                                    $(".message-text").text(data.text);
                                                    $(".message-subject").text(data.subject);
                                                    $(".message-to").text("Mensaje para: "+data.to);
                                                    $(".message-title").text("Ver mensaje")
                                                    if(data.type == "pb") {
                                                        var p = "<p class='prebooking-info-message'>Le recordamos que para poder permitir al usuario reservar, debe enviarle las condiciones de la reserva. Acceda a prereservas, y encontrará está preserva con los detalles de la misma. Una vez allí, podrá enviarle las condicione sy permitir así al usuario confirmar la reserva. Si lo desea, también puede comunicarse con el usuario para aclarar cuestiones.</p>";
                                                        $(".message-text").append(p);
                                                    }
                                                    $("#showMessage").show();

                                                }, error: function(){
                                                    $(".message-text").text(data.text);
                                                    $(".message-subject").text(data.subject);
                                                    $(".message-to").text("Mensaje para: "+data.to);
                                                    $(".message-title").text("Ver mensaje")
                                                    if(data.type == "pb") {
                                                        var p = "<p class='prebooking-info-message'>Le recordamos que para poder permitir al usuario reservar, debe enviarle las condiciones de la reserva. Acceda a prereservas, y encontrará está preserva con los detalles de la misma. Una vez allí, podrá enviarle las condicione sy permitir así al usuario confirmar la reserva</p>";
                                                        $(".message-text").append(p);
                                                    }
                                                    $("#showMessage").show();
                                                }
                                            });
                                        }
                                    })
                                </script>
                        </div>
                        <div id="account" class="tab-pane fade">
                            <h3>Configuración de la cuenta</h3>
                            <p>Desde aquí podrás actualizar los datos de tu cuenta</p>
                            {!! Form::open(['url' => 'user/update/' . Auth::user()->id, 'files' => true]) !!}
                            <div class="row">
                                <div class="form-group form-default col-xs-6">
                                    <label>Nombre</label>
                                    <input type="text" name="name" class="form-control">
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                </div>
                                <div class="form-group form-default col-xs-6">
                                    <label>Apellidos</label>
                                    <input type="text" name="surname" class="form-control">
                                    <span class="text-danger">{{ $errors->first('surname') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-update col-xs-6">
                                    <label>E-mail</label>
                                    <input type="text" name="email" class="form-control">
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                </div>
                                <div class="form-group form-update col-xs-6">
                                    <label>Contraseña</label>
                                    <input type="password" name="password" class="form-control">
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-update col-xs-6">
                                    <label>Teléfono</label>
                                    <input type="text" name="phone" class="form-control">
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                </div>
                            </div>
                            <div class="form-group form-submit-update">
                                <input type="submit" class="btn btn-success" value="Actulizar cuenta">
                            </div>
                            <script>
                                $('#flash-overlay-modal').modal();
                            </script>
                            {!! Form::close()!!}
                        </div>
                            @if(Auth::user()->owner)
                        <div id="newAccom" class="tab-pane fade">
                            @include('flash::message')
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
                                            <span class="btn btn-grey btn-file">
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
                                            <span class="btn btn-grey btn-file">
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
                                <input type="submit" class="btn btn-grey" value="Anunciar">
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
        @include("include.footer")
</body>
</html>