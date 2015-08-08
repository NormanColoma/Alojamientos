<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>
        <meta name="csrf-token" content="<?= csrf_token() ?>">
        <script src="code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script>
            $(function() {
                $( "#datepicker" ).datepicker();
            });
        </script>
    </head>
    <body>
		@include("include.header");
        <div class="container container-top">

            <div class="search-cont">
                <input class="form-control" data-provide="datepicker" data-val="true" data-val-date="El campo Disponible desde debe ser una fecha." data-val-required="El campo Disponible desde es obligatorio." id="avialableDate" name="avialableDate" type="text" value="">
            </div>
        </div>
    </body>
</html>
