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
    <h3><strong>Prereserva Realizada</strong></h3>
    <p>Su prereserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/1/details") !!}">alojamiento</a> ha sido realizada correctamente. Le recordamos que hemos envíado el mensaje
    que escribió, al propietario del alojamiento. El propietario le responderá con las condiciones establecidas para dicho
    alojamiento, y será entonces cuando pueda cerrar su reserva.</p>

    <h4><strong>Datos de la reserva</strong></h4>
    <ul>
        <li>Llegada: {!! $check_in !!}</li>
        <li>Salida: {!! $check_out !!}</li>
    </ul>
    <h4><strong>Datos propietario</strong></h4>
    <p>Le facilitamos los datos que el propietario a proporcionado, para que pueda ponerse en contacto con él si lo deasa.</p>
    <ul>
        <li>Nombre: {!! $owner->getName()!!}</li>
        <li>Teléfono: {!! $owner->getPhone() !!}</li>
        <li>E-mail: {!! $owner->getEmail() !!}</li>
    </ul>

</body>
</html>