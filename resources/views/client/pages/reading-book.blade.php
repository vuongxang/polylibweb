<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">

    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/pages/reading-book.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.turnjs.com/lib/turn.min.js"></script>

</head>

<body>
    <div class="topbar grid__full-width">
        <div class="topbar-item grid-custom">

            <div class="topbar__back">
                <a href="{{route('book.detail', ['id' => $book->id])}}"><i class="fas fa-reply"></i></a>
            </div>
            <div class="topbar__title">
                <h2>{{$book->title}}</h2>
            </div>
            <div class="topbar__tool">
                <div class="topbar-tool__item"><a href=""><i class="fas fa-list"></i></a></div>
                <div class="topbar-tool__item"><a href=""><i class="fas fa-font"></i></a></div>
                <div class="topbar-tool__item topbar-tool__search">
                    <a href=""><i class="fas fa-search"></i></a>
                    <div class="dropdown-search ">
                        <form action="" id="search-form">
                            <input type="text" id="pageNumber" placeholder="Nhập số trang">
                            <button><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="topbar-tool__item"><a href=""><i class="fas fa-bookmark"></i></a></div>
            </div>

        </div>

    </div>
    <div class="space__between grid-custom ">
        <button id="previous"><i class="fas fa-angle-left"></i></button>

        <div id="flipbook">
            @foreach($pages as $p)
            <div>
                <img src="{{ asset($p->url) }}" alt="" width="450px">
            </div>

            @endforeach
        </div>
        <button id="next"><i class="fas fa-angle-right"></i></button>
    </div>
    <div class=" grid-custom ">
        <div class="slide-container">
            <input type="range" min="0" max={{count($pages)}} value="1" id="myRange" class="slider">
            <div class="page-number"><span id="slider-value">1</span> / <span class="page-total">{{count($pages)}}</span> </div>
        </div>
    </div>
    <script type="text/javascript">
        console.log($('#flipbook').turn('view'));
        $('#flipbook').turn({}).turn('previous');
        $('#next').click(() => {
            $('#flipbook').turn('next');
            let pageNumb = $('#flipbook').turn('page');
            changeRange(pageNumb);
            $('#myRange').val(pageNumb);
            $('#slider-value').html(pageNumb);
        })
        $('#previous').click(() => {
            $('#flipbook').turn('previous');
            let pageNumb = $('#flipbook').turn('page');
            changeRange(pageNumb);
            $('#myRange').val(pageNumb);
            $('#slider-value').html(pageNumb);
        })
        $('#numb').click(() => {
            $('#flipbook').turn('display', 'single');
        })

        $('#numb3').click((pageNumber) => {
            $('#flipbook').turn('page', pageNumber);
        })
        $('.topbar-tool__search').click((e) => {
            e.preventDefault();
            $('.dropdown-search').toggleClass('active');
            $('#search-form').trigger("reset");

        })
        $('.dropdown-search').click((e) => {
            e.stopPropagation();
        })
        $('#search-form').submit(function(e) {
            e.preventDefault();
            const pageNumber = $('#pageNumber').val();

            if (!$('#flipbook').turn('hasPage', pageNumber) && pageNumber != 0) {
                console.log('Không tìm thấy')

            } else {
                if (pageNumber == 0) {
                    $('#flipbook').turn('page', 1);
                } else {
                    $('#flipbook').turn('page', pageNumber);
                }
            };
        });
        console.log($('#flipbook').turn('page'));

        $('#myRange').on('input', function() {
            let x = $('#myRange').val();
            changeRange(x)
            $('#flipbook').turn('page', x)
        });
        $("#flipbook").bind("turned", function(event, page, view) {
            console.log(event,page,view)

            $('#slider-value').html(view.join('-'))
        });

        function changeRange(x) {
            let pageTotal = $('.page-total').text();
            let perce = (x) / pageTotal * 100;
            let color = 'linear-gradient(90deg,rgb(66,91,168)' + perce + '%, rgb(214,214,214)' + perce + '%)';
            $('#myRange').css('background', color);
        }
        changeRange(1)
    </script>
</body>

</html>