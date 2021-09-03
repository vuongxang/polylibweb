<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
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
                        <img class="login__logo-img" src="{{asset('images/logo.png')}}" alt="">
                    </div>
                    
                    <div class="login__button center">
                        <a class="button button--google" href="{{ route('login.google') }}">
                            <img src="{{asset('images/google-icon.svg')}}" class="login__icon-google" alt=""><span> Đăng nhập bằng Google</span>
                        </a>
                    </div>
                    @if (session('message'))
                   
                    <div class="alert-wrap">
                        <div class="alert-message">{{ session('message') }} </div>
                        Nếu bạn có bất kì thắc mắc hay quan tâm nào, bạn có thể <a href="{{route('contact')}}" class="contact-link">liên hệ ngay với chúng tôi</a>
                        
                    </div>
                   
                    @endif
                    
                </div>
            </div>

        </div>

    </div>
</body>

</html>