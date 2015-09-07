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
<h3><strong>Nuevo Mensaje</strong></h3>
<p>Tiene un nuevo mensaje privado de  <strong>{!! $user->name ." ". $user->surname!!}</strong></p>
<div style="background-color: #e4e4e4;border-radius: 5px;"><p style="padding: 20px;font-style: italic;">"{!! $text !!}"</p></div>
<p>Para responder a este mensaje, por favor, acceda a su panel de control, mensajes, y podrá enviar una respuesta.</p>
<h4><strong>Datos del usuario</strong></h4>
<p>Le facilitamos los datos que el usuario ha proporcionado, para que pueda ponerse en contacto con él si lo deasa.</p>
<ul>
    <li>Nombre: {!! $user->name!!}</li>
    <li>Teléfono: {!! $user->phone !!}</li>
    <li>E-mail: {!! $user->email !!}</li>
</ul>
</body>
</html>