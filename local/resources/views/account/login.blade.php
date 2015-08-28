<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login page</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/login.css">
</head>
<body>
    @include("include.header")
    <div class="container container-height">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <h3>Log In</h3>
                </div>

                <div style="padding-top:30px" class="panel-body" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    {!! Form::open(['url' => 'login','class'=>'form-horizontal']) !!}

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="email" value="" placeholder="email">

                        </div>
                        <div class="form-group">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="contraseña">
                        </div>
                        <div class="form-group">
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        </div>


                        <div class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="login-remember" type="checkbox" name="remember" value="1"> Recuerdame
                                </label>
                            </div>
                        </div>


                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->

                            <div class="col-sm-12 controls">
                                <input type="submit" id="btn-login" class="btn btn-success" value="Login" name="btn-login">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    No tienes cuenta!
                                    <a  class="clickeable" href="register">
                                        Regístrate aquí
                                    </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}



                </div>
            </div>
        </div>

    </div>
    @include("include.footer")
</body>
</html>