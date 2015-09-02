<html>
<head>
    <meta charset="utf-8">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
        a {
            color: #5cb85c !important;
            text-decoration: none;
        }

        a:hover{
            text-decoration: underline;
        }

        ul li{
            margin-bottom: 15px;
        }

    </style>
</head>

<body>
<h3><strong>Nueva Prereserva</strong></h3>
<p>El usuario <strong>Norman</strong> ha realizado una prereserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/1/details") !!}">alojamiento</a>. A continucación le detallamos los datos de la reserva:</p>


<h4><strong>Datos de la reserva</strong></h4>
<ul>
    <li>Llegada: {!! "2015-20-10" !!}</li>
    <li>Salida: {!! "2015-25-10" !!}</li>
    <li>Número de personas: 3 personas</li>
</ul>
<h4><strong>Datos del viajero</strong></h4>
<p>Le facilitamos los datos que el viajero ha proporcionado, para que pueda ponerse en contacto con él si lo desea.</p>
<ul>
    <li>Nombre: {!! "Norman"!!}</li>
    <li>Teléfono: {!! "655381429" !!}</li>
    <li>E-mail: {!! "ua.norman@gmail.com" !!}</li>
</ul>
<p>Le recordamos que debe contestar a este mensaje mediante la aplicación para que el usuario pueda confirmar la reserva, una vez que ustes establezca las condiciones de
    las mismas.</p>
</body>
</html>