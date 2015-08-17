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
                    <li class="active"><a data-toggle="tab" href="#accoms">Mis alojamientos  <span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
                    <li><a data-toggle="tab" href="#pers">Mis inquilinos <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
                    <li><a data-toggle="tab" href="#messages">Bandeja de entrada <span class="badge">4</span></a></li>
                    <li><a data-toggle="tab" href="#menu3">Mi cuenta<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
                  </ul>

                  <div class="tab-content">
                         <div id="accoms" class="tab-pane fade in active">
                                 <h3>Alojamientos</h3>

                                 <p>Aquí se te mostrarán todos los alojamientos que hayas anunciado hasta el momento.</p>
                                 <ul>
                                     <li>
                                         <div class="accomodation">
                                             {!! Html::image('/local/resources/assets/img/accoms/accom1.jpg') !!}
                                             <div class="accom-descrip">
                                                 <h3 class="accom-title">Casa rural con vistas preciosas</h3>
                                                 <p class="accom-description">Aquí se mostrará una breve descripción sobre el alojamiento. Donde se podrá contar algo acerca del alojamiento. Será el mismo que se muestre cuando los usarios entren a ver el detalle de un alojamiento, aunque se limitará el número de caracteres.</p>
                                                 <a href="#" class="btn btn-primary btn-delete-accom"><span class="glyphicon glyphicon-remove"></span> Eliminar</a>
                                                 <a href="#" class="btn btn-success btn-update-accom"><span class="glyphicon glyphicon-pencil"></span> Actualizar</a>
                                             </div>
                                         </div>
                                     </li>
                                 </ul>
                        </div>
                        <div id="pers" class="tab-pane fade">
                                <h3>Menu 1</h3>
                                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                        </div>
                        <div id="messages" class="tab-pane fade">
                                <h3>Menu 2</h3>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                                <h3>Menu 3</h3>
                                <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
                        </div>
                </div>
        </div>
</body>
</html>