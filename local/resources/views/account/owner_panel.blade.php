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
                      <li><a data-toggle="tab" href="#newAccom">Añadir alojamiento  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></li>
                    <li><a data-toggle="tab" href="#pers">Mis clientes <span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
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
                        <div id="newAccom" class="tab-pane fade">
                            <h3>Nuevo Alojamiento</h3>
                            {!! Form::open(['url' => 'accommodation/publish']) !!}
                            <div class="form-group form-default">
                                <label>Título del anuncio</label>
                                <input type="text" name="new-accom-title" class="form-control">
                            </div>
                            <div class="row">
                                <div class="form-group form-default col-xs-6">
                                    <label>Ciudad</label>
                                    <input type="text" name="new-accom-city" class="form-control new-accom-city">

                                </div>
                                <div class="form-group form-default col-xs-6">
                                    <label>Provincia</label>
                                    <input type="text" name="new-accom-province" class="form-control new-accom-province">
                                </div>
                            </div>
                            <div class="form-group form-default">
                                <label>Precio por persona</label>
                                <input type="text" name="new-accom-price" class="form-control">
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
                                </div>
                                <div class="form-group form-default col-xs-6">
                                    <label>Exterior</label>
                                    <textarea class="form-control" placeholder="Introduce una breve descripción del exterior del alojamiento. Este campo no es obligatorio" name="new-accom-outside"></textarea>
                                </div>
                            </div>
                            <div class="form-group ">
                                <label>Descripción del anuncio</label>
                                <textarea class="form-control form-desc" name="new-accom-desc"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Anunciar">
                            </div>
                            {!! Form::close() !!}
                        </div>
                </div>
        </div>
</body>
</html>