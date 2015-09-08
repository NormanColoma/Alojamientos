<html>
<head>
    <meta charset="utf-8">
    <style>
        body{
            font-family: 'Open Sans', sans-serif;
        }
        a {
            color: #5cb85c;
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
<h3><strong>Confirmar Rerserva</strong></h3>
<p>Su prereserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$id."/details") !!}">alojamiento</a> ha sido aceptada por el propietario. A continuación, haga click
    sobre el botón "Confirmar Reserva", para confirmar su reserva.</p>

<h4><strong>Datos de la reserva</strong></h4>
<ul>
    <li>Llegada: {!! $check_in !!}</li>
    <li>Salida: {!! $check_out !!}</li>
</ul>
<h4><strong>Datos propietario</strong></h4>
<p>Le facilitamos los datos que el propietario a proporcionado, para que pueda ponerse en contacto con él si lo desea.</p>
<ul>
    <li>Nombre: {!! $owner->name!!}</li>
    <li>Teléfono: {!! $owner->phone !!}</li>
    <li>E-mail: {!! $owner->email !!}</li>
</ul>
<div style="background-color: #e4e4e4;border-radius: 5px;"><p style="padding: 20px;font-style: italic;">"{!! $text !!}"</p></div>
<a style="background-color: #5cb85c !important;border-color: #3bb83c !important;border-radius: 2px;display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;color:white;" href="{!! Url::to("http://localhost:8080/alojamientos/booking/".$id."/confirm") !!}">Confirmar Reserva</a>

</body>
</html>