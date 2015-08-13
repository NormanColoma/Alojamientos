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
    <div class="container">
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
                                <input type="submit" id="btn-login" class="btn btn-success" value="Login">
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    No tienes cuenta!
                                    <a  class="clickeable" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                        Regístrate aquí
                                    </a>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}



                </div>
            </div>
        </div>
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3>Nuevo Usuario</h3>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" class="clickeable"  onclick="$('#signupbox').hide(); $('#loginbox').show()">Log In</a></div>
                </div>
                <div class="panel-body" >
                    <form id="signupform" class="form-horizontal" role="form">

                        <div id="signupalert" style="display:none" class="alert alert-danger">
                            <p>Error:</p>
                            <span></span>
                        </div>



                        <div class="form-group">
                            <label for="email" class="col-md-3 control-label">Email</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="email" placeholder="Email Address">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="firstname" class="col-md-3 control-label">Nombre</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="firstname" placeholder="First Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="col-md-3 control-label">Apellidos</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-md-3 control-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="icode" class="col-md-3 control-label">Teléfono</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="phone" placeholder="">
                            </div>
                        </div>

                        <div class="input-group">
                            <div class="checkbox">
                                <label>
                                    <input id="check-owner" type="checkbox" name="owner" value="1"> Soy propietario
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <!-- Button -->
                            <div class="col-md-offset-3 col-md-9">
                                <button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>