<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Laravel</title>
        <meta charset="utf-8">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        {!! Html::style('/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
        {!! Html::style('/local/resources/assets/styles/styles.css') !!}
        {!! Html::style('/local/resources/assets/styles/datepicker/bootstrap-datepicker.min.css') !!}
        {!! Html::style('/local/resources/assets/styles/datepicker/bootstrap-datepicker.css') !!}
        {!! Html::style('/local/resources/assets/styles/datepicker/bootstrap-datepicker.css') !!}
        {!! Html::script('/local/resources/assets/scripts/jquery-2.1.4.min.js') !!}
        {!! Html::script('/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
        {!! Html::script('/local/resources/assets/scripts/datepicker/bootstrap-datepicker.js') !!}
        {!! Html::script('/local/resources/assets/scripts/datepicker/bootstrap-datepicker.min.js') !!}
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
                <a class="navbar-brand navbar-img" href="{!! URL::to('home')!!}"> {!! Html::image('/local/resources/assets/img/alojablanco.png') !!}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <?php
                            $url= "";
                            if(Auth::check()){
                                if(Auth::user()->admin)
                                    $url = "manage/admin";
                                else if(Auth::user()->owner)
                                    $url = "manage/owner";
                                else
                                    $url = "manage/traveler";
                            }
                        ?>
                        @if (Auth::check())
                            <a class="hover" href="{!! URL::to($url)!!}">{!! Auth::user()->name !!}</a>
                        @else
                            <a class="hover" href="login">Log in</a>
                        @endif

                    </li>
                    <li>
                        @if (Auth::check())
                            {!! HTML::link('logout', 'log out', array('class' => 'hover'))!!}
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
