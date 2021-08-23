<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="icon" href="{{asset('images/logo.png')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/layouts/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/layouts/footer.css')}}">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="login-form col-6 offset-3">
                <form method="POST" action="">
                    @csrf
                    <div class="text-center">
                        <a href="" aria-label="Space">
                            <img class="mb-3 logo-image" src="{{URL::to('images/logo.png')}}" alt="Logo" width="60" height="60">
                        </a>
                    </div>
                    <div class="text-center mb-4">
                        <h1 class="h3 mb-0">Vui lòng đăng nhập</h1>
                        <p>Signin to manage your account.</p>
                    </div>
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
            
                    
                    <div class="js-form-message mb-3">
                        <div class="js-focus-state input-group form">
                        <div class="input-group-prepend form__prepend">
                            <span class="input-group-text form__text">
                            <i class="fa fa-envelope form__text-inner"></i>
                            </span>
                        </div>
                        <input type="email" class="form-control form__input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="Email" autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Password" autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                          <!-- Checkbox -->
                          <div class="custom-control custom-checkbox d-flex align-items-center text-muted">
                            <input class="custom-control-input"type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="remember">
                              Remember Me
                            </label>
                          </div>
                          <!-- End Checkbox -->
                        </div>
                    </div>
                 
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-primary login-btn btn-block">Signup</button>
                    </div>
                    <div class="text-center mb-3">
                        <p class="text-muted"><a href="{{route('password.request')}}">Quên mật khẩu?</a></p>
                    </div>
                    <p class="small text-center text-muted mb-0">All rights reserved. © Space. 2021 soengsouy.com.</p>
                </form>
            </div>
        </div>        
    </div>
    <div class="toast" data-autohide="false">
        <div class="toast-header">
        <strong class="mr-auto text-primary">Toast Header</strong>
        <small class="text-muted">5 mins ago</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
        </div>
        <div class="toast-body">
        Some text inside the toast body
        </div>
    </div>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>