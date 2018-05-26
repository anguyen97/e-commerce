<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AShoes</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="{{ asset('admin_assets/login_assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/login_assets/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/login_assets/css/form-elements.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/login_assets/css/style.css') }}">
    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{ asset('admin_assets/login_assets/ico/favicon.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('admin_assets/login_assets/ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('admin_assets/login_assets/ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('admin_assets/login_assets/ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('admin_assets/login_assets/ico/apple-touch-icon-57-precomposed.png') }}">
    <style>
    .btn-circle.btn-xl {
        width: 70px;
        height: 70px;
        padding: 20px 16px;
        border-radius: 35px;
        font-size: 24px;
        line-height: 1.33;
        /*color: green;*/
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 6px 0px;
        border-radius: 15px;
        text-align: center;
        font-size: 12px;
        line-height: 1.42857;
    }
    .btn-circle:hover{
        color: yellow;
        border: 1px solid yellow;
    }
</style>
</head>

<body style="background-image: url({{ asset('admin_assets/login_assets/img/backgrounds/1.jpg') }})" style="position: relative;">
    <div style="height: 50px">
    </div>
    <a href="{{ route('admin.register') }}" title="Resgister" style="position: absolute; z-index: 100; right: 5%; top: 50px;" class="btn btn-success btn-circle btn-xl fa fa-link">

    </a>

    <div class="container" >
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
                <h1 style="color: white"><strong>AShoes Admin</strong></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 form-box">
                <div class="form-top">
                    <h3 >Login to our site</h3>

                    <div class="form-bottom">
                        <form role="form" action="{{ route('admin.login.process') }}" method="post" class="login-form">
                            @csrf
                            <div class="form-group">
                                <label for="form-username">Email</label>
                                <input type="text" name="email"  class="form-username form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="form-username email" required autofocus placeholder="Email">

                                @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif

                            </div>
                            <div class="form-group">
                                <label for="form-password">Password</label>
                                <input type="password" class="form-password form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required id="form-password password" placeholder="Password">

                                @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif

                            </div>
                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn">Sign in!</button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <span class="col-sm-4 col-sm-offset-4 social-login">
                    <h3>...or login with:
                        <span class="social-login-buttons">
                            <a class="btn btn-link-1 btn-link-1-facebook btn-lg fa fa-facebook" href="" >
                            </a>
                            <a class="btn btn-link-1 btn-link-1-twitter btn-lg fa fa-twitter" href="">
                            </a>
                            <a class="btn btn-link-1 btn-link-1-google-plus btn-lg fa fa-google-plus" href="" >
                            </a>
                        </span>
                    </h3>
                </span>
            </div> -->
        </div>
        <i class="fa fa-registered" style="height: 30px; width: 30px"></i>
        <!-- Javascript -->
        <script src="{{ asset('admin_assets/login_assets/js/jquery-1.11.1.min.js') }}"></script>
        <script src="{{ asset('admin_assets/login_assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin_assets/login_assets/js/jquery.backstretch.min.js') }}"></script>
        <script src="{{ asset('admin_assets/login_assets/js/scripts.js') }}"></script>

    <!--[if lt IE 10]>
        <script src="assets/js/placeholder.js"></script>
    <![endif]-->


</body>

</html>