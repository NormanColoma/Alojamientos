<!DOCTYPE html>
<html>
<head>
    <title>Laravel</title>


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
                    <h3>Contancto</h3>
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
                    <p class="margin-info-extra">
                        {!! Html::image('/local/resources/assets/img/fb.png') !!}
                        {!! Html::image('/local/resources/assets/img/tw.png') !!}
                        {!! Html::image('/local/resources/assets/img/gp.png') !!}
                    </p>
                </div>
            </li>
            <li>
                <div>
                    <h3>Menú</h3>
                        <a class="margin-info-medium">Iniciar sesión</a>
                        <a class="margin-info">Contacto</a>
                        <a class="margin-info">Anuncia tu alojamiento</a>
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
