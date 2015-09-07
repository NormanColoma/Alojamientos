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
<p>El usuario <strong>{!! $name !!}</strong> le ha enviado una nueva cuestión:</p>

<h4><strong>Mensaje enviado por el usuario</strong></h4>
<div style="background-color: #e4e4e4;border-radius: 5px;"><p style="padding: 20px;font-style: italic;">"{!! $text !!}"</p></div>
<p>Para responder con las condiciones y permitir al usuario confirmar la reserva,
    acceda a su cuenta, prereservas, y pulse sobre "Enviar condiciones".</p>
<h4><strong>Datos del viajero</strong></h4>
<p>Le facilitamos los datos que el usuario ha proporcionado, para que pueda ponerse en contacto con él si lo desea.</p>
<ul>
    <li>Nombre: {!! $name !!}</li>
    <li>E-mail: {!! $email !!}</li>
</ul>
</body>
</html>