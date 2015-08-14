<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Laravel</title>
        <meta charset="utf-8">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="./bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/styles.css">
        <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/datepicker/bootstrap-datepicker.min.css">
        <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/datepicker/bootstrap-datepicker.css">
        <script type="text/javascript" src="./local/resources/assets/scripts/jquery-2.1.4.min.js" ></script>
        <script type="text/javascript" src="./bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./local/resources/assets/scripts/datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="./local/resources/assets/scripts/datepicker/bootstrap-datepicker.js"></script>
    </head>
    <body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Project name</a>

            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        @if (Auth::check())
                            <a class="hover" href="">{!! Auth::user()->name !!}</a>
                        @else
                            <a class="hover" href="login">Log in</a>
                        @endif

                    </li>
                    <li>
                        @if (Auth::check())
                            <a class="hover" href="logout">Logout</a>
                        @else
                            <a class="hover">Anuncia tu alojamiento</a>
                        @endif
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    </body>
</html>
