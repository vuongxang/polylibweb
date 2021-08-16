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

    <script src="{{ asset('js/app.js') }}" ></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/layouts/header.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/layouts/footer.css')}}">
    @yield('css')
</head>

<body>
    <div class="container-custom">
        <div class="grid-custom">
            @include('client.layouts.header')

            @yield('content')
        </div>
        @include('client.layouts.footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        @yield('script')
        <!-- <script src="js/app.js"></script> -->
        
        <script>
            $(document).ready(function() {
                $('#addStar').change('.star', function(e) {
                    $(this).submit();
                });
                $("#myBtn").click(function() {
                    $('.toast').toast('show');
                });
            });
            var pusher = new Pusher('{{ env("PUSHER_APP_KEY")}}', {
                cluster: "ap1"
            });
            var channel = pusher.subscribe('NotificationEvent');
            channel.bind('send-message', function(data) {
                console.log(data)

            });

            function Deleted_at() {
                var conf = confirm('Bạn chắc chắn muốn trả sách');
                return conf;
            }

          
        </script>
</body>

</html>