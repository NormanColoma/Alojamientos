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

        .message{
            background-color: #e4e4e4;
            border-radius: 5px;
        }

        .message p{
            padding: 20px;
            font-style: italic;
        }

    </style>
</head>

<body>
<h3><strong>Nueva Prereserva</strong></h3>
<p>El usuario <strong>{!! $user->name !!}</strong> ha realizado una prereserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/1/details") !!}">alojamiento</a>. A continucación le detallamos los datos de la reserva:</p>


<h4><strong>Datos de la reserva</strong></h4>
<ul>
    <li>Llegada: {!! $check_in !!}</li>
    <li>Salida: {!! $check_out !!}</li>
    <li>Número de personas: {!! $capacity !!} personas</li>
</ul>
<h4><strong>Datos del viajero</strong></h4>
<p>Le facilitamos los datos que el viajero ha proporcionado, para que pueda ponerse en contacto con él si lo desea.</p>
<ul>
    <li>Nombre: {!! $user->name !!}</li>
    <li>Teléfono: {!! $user->phone !!}</li>
    <li>E-mail: {!! $user->email !!}</li>
</ul>
<h4><strong>Mensaje enviado por el uuario</strong></h4>
<div class="message"><p>"{!! $message !!}"</p></div>
</body>
</html>