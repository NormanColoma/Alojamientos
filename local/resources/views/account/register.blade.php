<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register page</title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" type="text/css" href="./local/resources/assets/styles/register.css">
</head>
<body>
@include("include.header")
<div class="container">
    <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3>Nuevo Usuario</h3>
                <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" class="clickeable" href="login">Log In</a></div>
            </div>
            <div class="panel-body" >
                <form id="signupform" class="form-horizontal" role="form" action="register" method="post">
                    {!! csrf_field() !!}
                    <div id="signupalert" style="display:none" class="alert alert-danger">
                        <p>Error:</p>
                        <span></span>
                    </div>



                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label">Email</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="email" placeholder="Email Address" value="{{ old('email') }}">
                        </div>

                    </div>
                    <div class="form-group form-error" hidden="true">
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="firstname" class="col-md-3 control-label">Nombre</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="name" placeholder="First Name" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="form-group form-error" hidden="true">
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="col-md-3 control-label">Apellidos</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="surname" placeholder="Last Name" value="{{ old('surname') }}">
                        </div>
                    </div>
                    <div class="form-group form-error" hidden="true">
                        <span class="text-danger">{{ $errors->first('surname') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label">Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group form-error" hidden="true">
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="icode" class="col-md-3 control-label">Teléfono</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="phone" placeholder="" value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="form-group form-error" hidden="true">
                        <span class="text-danger">{{ $errors->first('phone') }}</span>
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
                            <button id="btn-signup" type="submit" class="btn btn-info" name="btn-register"><i class="icon-hand-right"></i> &nbsp Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <script>
                $(".form-error").each(function(){
                    var error = $(this).find(".text-danger").text();
                    if(error != "")
                        $(this).show();
                })
            </script>
        </div>
    </div>
</div>
</body>
</html>