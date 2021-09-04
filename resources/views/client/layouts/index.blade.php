<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="icon" href="{{ asset('/images/logo.png') }}">

    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />

    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/netdna.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/layouts/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/layouts/footer.css') }}">
    @yield('css')
</head>

<body>
    <div class="container-custom">
        <div class="grid-custom">
            @include('client.layouts.header')

            @yield('content')
        </div>
        @include('client.layouts.footer')

    </div>
    <!-- Chống copy nột dung -->
    <!-- <script type="text/javascript">
        $(document).ready(function(){
        $('*').bind('cut copy paste contextmenu', function (e) {
            e.preventDefault();
        })});
    </script> -->
    <!-- end -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="application/javascript">
        function $init() {return true;}
    </script>
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('editor1',{
            filebrowserUploadUrl : "{{ url('uploads-ckeditor?_token='.csrf_token()) }}",
            // // filebrowserBrowseUrl : "{{ url('')}}/filemanager/dialog.php?field_id=imgField&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee",
            filebrowserUploadMethod : 'form',
            // toolbar:[
            //     ['CodeSnippet','Scroll']
            //     [ 'Source'],
            //     ['Radio '],
            //     ['Highlight '],
            //     [ 'Undo', 'Redo', '-','Bold', 'Italic','Underline', 'Strike', 'Subscript', 'Superscript'],
            //     ['JustifyLeft','JustifyCenter', 'JustifyRight', 'JustifyBlock'],
            //     [ 'Image','Table', 'Link', 'Unlink','Anchor'],
            //     [ 'Find', 'Replace'],
            //     ['Cut','Copy','Paste','PasteText','PasteFromWord'],
            //     ['Document','Preview','Print','Sample','ExportPdf' ],
            //     ['RemoveFormat'],
            //     ['BidiLtr', 'BidiRtl'],
            //     [ 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'],
            //     ['Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor' ],
            //     ['Maximize','ShowBlocks'],
            // ]
        });
    </script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script> -->
    @yield('script')

    <script>
        $(document).ready(function() {
            $('#addStar').change('.star', function(e) {
                $(this).submit();
            });



        });

        function Deleted_at() {
            var conf = confirm('Bạn chắc chắn muốn trả sách');
            return conf;
        }
    </script>
</body>

</html>
