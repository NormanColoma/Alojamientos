<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact page</title>
    <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/contact.css">
</head>
<body>
@include("include.header")
<div class="container container-height">
    @include('flash::message')
    <h3>Contacta con AlojaRural</h3>
    <p>Envía tu consulta sobre cualquier duda que tengas. Te responderemos con la mayor brevedad posible</p>
    {!! Form::open(['url'=> "sendQuestion"]) !!}
        <div class="form-group">
            <label>Asunto</label>
            <input type="text" class="form-control form-subject" name="subject">
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        </div>
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control form-subject" name="name">
            <span class="text-danger">{{ $errors->first('name') }}</span>
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="text" class="form-control form-subject" name="email">
            <span class="text-danger">{{ $errors->first('email') }}</span>
        </div>
        <div class="form-group">
            <label>Mensaje</label>
            <textarea class="form-control form-text" name="text"></textarea>
            <span class="text-danger">{{ $errors->first('text') }}</span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Enviar">
        </div>
    {!! Form::close() !!}
    <script>
        $('#flash-overlay-modal').modal();
    </script>
</div>
@include("include.footer")
</body>
</html>