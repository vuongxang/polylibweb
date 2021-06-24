<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
</head>

<body>
    <div class="container ">
        <div class="grid center">
            <div class="login center">
                <div class="login__content">
                    <div class=" center">
                        <h2 class="login__header">Đăng nhập</h2>
                    </div>
                    <div class="login__logo center">
                        <img src="{{asset('images/logo.png')}}" alt="">
                    </div>
                    <div class="login__button center">
                        <button class="button button--google">
                            <img src="{{asset('images/google-icon.svg')}}" class="login__icon-google" alt=""><span> Google</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>