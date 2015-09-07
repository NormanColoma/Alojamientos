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
<p>Su mensaje ha sido enviado correctamente. Le detallamos su mensaje enviado:</p>
<div style="background-color: #e4e4e4;border-radius: 5px;"><p style="padding: 20px;font-style: italic;">"{!! $text !!}"</p></div>
<h4><strong>Datos del viajero</strong></h4>
<p>Le facilitamos los datos que usted proporcionó para la consulta.</p>
<ul>
    <li>Nombre: {!! $name !!}</li>
    <li>E-mail: {!! $email !!}</li>
</ul>
</body>
</html>