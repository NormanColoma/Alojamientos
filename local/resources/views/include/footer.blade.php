<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>
<body>
<div class="footer">
    <div class="container">
        <ul class="footer-info-list">
            <li>
                <div>
                    {!! Html::image('/local/resources/assets/img/alojarural_logo.png') !!}
                    <p class="margin-info">
                        Tu buscador de alojamientos rurales. Busca, reserva y valora tu estancia o si lo deseas
                        anuncia tu alojamiento rural y gestiona tus reservas, clientes calendario de ocupación...
                    </p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Contacto</h3>
                    <p class="margin-info-extra">
                        <span class="glyphicon glyphicon-phone-alt"></span>
                        +34 686236338
                    </p>
                    <p class="margin-info">
                        <span class="glyphicon glyphicon-envelope"></span>
                        info@alojarural.es
                    </p>
                </div>
            </li>
            <li class="socialnet">
                <div>
                    <h3>Síguenos</h3>
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    </ul>
                </div>
            </li>
            <li>
                <div>
                    <h3>Menú</h3>
                        <a class="margin-info-medium" href="{!! URL::to("login") !!}">Iniciar sesión</a>
                        <a class="margin-info" href="{!! URL::to("contact") !!}">Contacto</a>
                        <a class="margin-info" href="{!! URL::to('manage/owner#newAccom')!!}">Anuncia tu alojamiento</a>
                    </p>

                </div>
            </li>
        </ul>
        <ul class="footer-info-list-mobile">
            <p>&copy; 20515 - InstantPiso</p>
        </ul>
    </div>
</div>
</body>
</html>
