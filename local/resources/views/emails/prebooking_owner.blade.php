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
<p>El usuario <strong>{!! Auth::user()->name !!}</strong> ha realizado una prereserva del <a href="{!! URL::to("http://localhost:8080/alojamientos/accommodation/1/details") !!}">alojamiento</a>. A continucación le detallamos los datos de la reserva:</p>


<h4><strong>Datos de la reserva</strong></h4>
<ul>
    <li>Llegada: {!! $check_in !!}</li>
    <li>Salida: {!! $check_out !!}</li>
    <li>Número de personas: {!! $capacity !!}  personas</li>
</ul>
<h4><strong>Datos del viajero</strong></h4>
<p>Le facilitamos los datos que el viajero ha proporcionado, para que pueda ponerse en contacto con él si lo desea.</p>
<ul>
    <li>Nombre: {!! Auth::user()->name !!}</li>
    <li>Teléfono: {!! Auth::user()->phone !!}</li>
    <li>E-mail: {!! Auth::user()->email !!}</li>
</ul>
<h4><strong>Mensaje enviado por el usuario</strong></h4>
<div style="background-color: #e4e4e4;border-radius: 5px;"><p style="padding: 20px;font-style: italic;">"{!! $text !!}"</p></div>
<p>Para responder con las condiciones y permitir al usuario confirmar la reserva, acceda a su cuenta, prereservas, y pulse sobre "Enviar condiciones".</p>
</body>
</html>