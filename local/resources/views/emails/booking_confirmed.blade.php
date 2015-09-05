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
<h3><strong>Reserva Confirmada</strong></h3>
<p>El usuario <strong>{!! Auth::user()->name !!}</strong> ha confirmado la reserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/".$id."/details") !!}">alojamiento</a>. A continucación le detallamos los datos de la reserva:</p>


<h4><strong>Datos de la reserva</strong></h4>
<ul>
    <li>Llegada: {!! $check_in !!}</li>
    <li>Salida: {!! $check_out !!}</li>
    <li>Número de personas: {!! $capacity !!}  personas</li>
    <li>Precio final establecido {!! $price !!}</li>
</ul>
<h4><strong>Datos del viajero</strong></h4>
<p>Datos del usuario que confirmó y realizó la reserva actual</p>
<ul>
    <li>Nombre: {!! Auth::user()->name !!}</li>
    <li>Teléfono: {!! Auth::user()->phone !!}</li>
    <li>E-mail: {!! Auth::user()->email !!}</li>
</ul>
<p>Puede acceder a su panel de control, Reservas, para ver esta reserva.</p>
</body>
</html>