<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$book->title}}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap">
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <link rel="stylesheet" href="{{asset('css/reset.css')}}">
    <link rel="stylesheet" href="{{asset('css/base.css')}}">
    <link rel="stylesheet" href="{{asset('css/client/pages/reading-book.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{asset('js/client/turn.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/ColonelParrot/ProtectImage.js@v1.2/src/ProtectImage.min.js"></script>
    <!-- <script type="text/javascript" src="{{asset('js/turn/extras/jquery.min.1.7.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/turn/extras/modernizr.2.5.3.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/turn/lib/hash.js')}}"></script> -->
</head>
<!-- oncontextmenu="return false" -->

<body>
    <div class="topbar grid__full-width">
        <div class="topbar-item grid-custom">

            <div class="topbar__back">
                <a href="{{route('book.detail', ['slug' => $book->slug])}}"><i class="fas fa-reply"></i></a>
            </div>
            <div class="topbar__title">
                <h2>{{$book->title}}</h2>
            </div>
            <div class="topbar__tool">
                <div class="topbar-tool__item topbar-tool__display"><a href=""><i class="fas fa-eye"></i></a></div>
                <div class="topbar-tool__item topbar-tool__thumbnails"><a href=""><i class="fas fa-th-large"></i></a></div>
                <div class="topbar-tool__item topbar-tool__search">
                    <a href=""><i class="fas fa-search"></i></a>
                    <div class="dropdown-search ">
                        <form action="" id="search-form">
                            <input type="text" id="pageNumber" placeholder="Nh???p s??? trang">
                            <button><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="topbar-tool__item topbar-tool__list"><a href=""><i class="fas fa-list"></i></a></div>
                <div class="topbar-tool__item topbar-tool__bookmark"><a href=""><i class="far fa-bookmark"></i></a></div>
                <!-- <div class="zoom-icon zoom-icon-in"><a href=""><i class="fas fa-expand"></i></a></div> -->
                <div id="toast"></div>

            </div>

        </div>
        <div class="topbar-aside hidden">
            <div class="topbar-aside__header">Danh s??ch trang s??ch</div>
            <div class="topbar-aside__list">

                <div class="topbar-aside__item">
                    @foreach($pages as $key => $p)
                    <a href="" class="aside-item__link">
                        <img class="aside-item__img" src="{{asset($p->url) }}" alt="" />
                    </a>
                    <div class="aside-item__footer">
                        {{$key+1}}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="topbar-bookmark__wrap hidden">
            <div class="topbar-bookmark__header">
                <div class="bookmark-header__text">Bookmarks</div>
                <div class="bookmark-header__icon"><button><i class="fas fa-times"></i></button></div>
            </div>
            <div class="topbar-bookmark__content-wrap">
            </div>
            <!--             
            <div class="topbar-bookmark__body">
                <div class="topbar-bookmark__page">
                    <a href="">
                        <img src="https://books.google.com/books/publisher/content/reader?id=IGoEDgAAQBAJ&hl=en-GB&pg=PP1&img=1&zoom=1&subver=ACfU3U0Em1I3y_cVlVYc7Q7mkx0HhxJnBQ&sig=ACfU3U2ZDeTLeY4FbVY0AQHPs7xdWj6uog&source=ge-web-app&w=70" alt="">
                    </a>
                </div>
                <div class="topbar-bookmark__content">
                    <div class="topbar-content__page">
                        <a href="">
                            Trang s??? 6

                        </a>
                    </div>
                    <div class="topbar-content__time">
                        1 ph??t tr?????c
                    </div>
                </div>
                <div class="topbar-bookmark__button">
                    <a href="" class="topbar-bookmark__button-link">
                        <i class="fas fa-trash-alt"></i>
                    </a>

                </div>
            </div> -->

        </div>
    </div>
    <div class="space__between grid-custom ">
        <button id="previous"><i class="fas fa-angle-left"></i></button>

        <div id="flipbook">

            @foreach($pages as $p)
            <div class="flipbook-wrapper">
                <img class="flipbook-img" src="{{asset($p->url) }}" data-id="{{$p->id}}" alt="" protected />
            </div>

            @endforeach
        </div>
        <button id="next"><i class="fas fa-angle-right"></i></button>
    </div>
    <div id="zoom-container"></div>
    <div class=" grid-custom ">
        <div class="slide-container">
            <input type="range" min="0" max={{count($pages)}} value="1" id="myRange" class="slider">
            <div class="page-number"><span id="slider-value">1</span> / <span class="page-total">{{count($pages)}}</span> </div>
        </div>
    </div>

    <!-- Ch???ng copy n???t dung -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('*').bind('cut copy paste contextmenu', function(e) {
                e.preventDefault();
            })
        });
    </script>
    <!-- end -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/medium-zoom/1.0.6/medium-zoom.min.js" integrity="sha512-N9IJRoc3LaP3NDoiGkcPa4gG94kapGpaA5Zq9/Dr04uf5TbLFU5q0o8AbRhLKUUlp8QFS2u7S+Yti0U7QtuZvQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        // Khoong cho xem nguon trang
        /**
         * Khi ng?????i d??ng b???t tab l??n v??o network v???n xem ???????c d??? li???u g???i ??i v?? nh???n v???
         * T???t F12 c??ng l?? m???t gi???i ph??p ????? tr??nh ng?????i d??ng c?? th??? xem ???????c d??? li???u h??nh ???nh
         */

        document.addEventListener('contextmenu', event => event.preventDefault());

        document.onkeypress = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                return false;
            }
        }
        document.onmousedown = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                return false;
            }
        }
        document.onkeydown = function(event) {
            event = (event || window.event);
            if (event.keyCode == 123) {
                return false;
            }
        }

        jQuery(document).ready(function($) {
            $(document).keydown(function(event) {
                var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

                if (event.ctrlKey && (pressedKey == "c" || pressedKey == "u")) {
                    //disable key press porcessing
                    return false;
                }
            });
        });
        
        window.onload = () => {
            // ProtectImageJS.protect(document.querySelectorAll("img"))
            // $('#flipbook').turn();
        }

        moment.locale('vi');
        // Assign variable
        let topBarBookMark = $('.topbar-bookmark__wrap'); // Bookmark dropdown
        let topBarBookMarkIcon = $('.bookmark-header__icon'); // Bookmark button times 

        // Thumbnail variable 
        let thumbnailEl = $('.topbar-tool__thumbnails');
        let topbarAside = $('.topbar-aside');
        let topbarLink = [...$('.aside-item__link')];

        let bookImageList = document.querySelectorAll(".flipbook-img");
        /**
         * Zoom ???nh
         */
        mediumZoom(document.querySelectorAll(".flipbook-img"), {
            background: '#ccc',
            margin: 24,
            scrollOffset: 500,
            container: '#zoom-container'

        })
        $('#flipbook').turn();


        /** 
         * Khi b???m v??o n??t con m???t tr??n tobar
         * Hi???n th??? trang s??ch theo 1 trang ho???c 2 trang
         */
        $('.topbar-tool__display').click(e => {
            e.preventDefault();
            if ($('#flipbook').turn('display') == 'double') {
                $('#flipbook').width('450px');
                $('#flipbook').height('580px');
                return $('#flipbook').turn('display', 'single')
            }
            if ($('#flipbook').turn('display') == 'single') {
                $('#flipbook').css('width', '900px');
                $('#flipbook').css('height', '580px');
                return $('#flipbook').turn('display', 'double')
            }
        })


        //Topbar thumbnails h??nh ???nh c???a cu???n s??ch

        // B???t s??? ki???n b???m v??o button thumbnail 
        thumbnailEl.click((event) => {
            event.preventDefault();
            event.stopPropagation();
            topbarAside.toggleClass('hidden');
            topBarBookMark.addClass('hidden');
            $('.dropdown-search').removeClass('active');

        })
        // Ng??n ch???n s??? ki???n khi b???m v??o aside
        topbarAside.click((event) => {
            event.stopPropagation();
        })
        // Chuy???n trang khi b???m v??o ???nh 
        topbarLink.forEach((item, index) => {
            item.addEventListener('click', (event) => {
                event.preventDefault();
                $('#flipbook').turn('page', index + 1);
                changeRange(index + 1);
                $('#myRange').val(index + 1);
            })
        })


        /** 
         * Ch???c n??ng t??m ki???m trang s??ch
         * Sau khi b???m icon t??m ki???m trang s??ch hi???n ra dropdown t??m ki???m form
         * Gi??p ng?????i d??ng c?? th??? di chuy???n ?????n trang s??ch c???n t??m
         */
        $('.topbar-tool__search').click((e) => {
            e.preventDefault();
            e.stopPropagation();
            $('.dropdown-search').toggleClass('active');
            $('#search-form').trigger("reset");
            topBarBookMark.addClass('hidden');
            topbarAside.addClass('hidden');
        })


        // Ng??n ch???n s??? ki???n n???i b???t khi b???m v??o ?? t??m ki???m
        $('.dropdown-search').click((e) => {
            e.stopPropagation();
        })

        // search form
        $('#search-form').submit(function(e) {
            e.preventDefault();
            const pageNumber = $('#pageNumber').val();

            if (!$('#flipbook').turn('hasPage', pageNumber) && pageNumber != 0) {
                console.log('Kh??ng t??m th???y')

            } else {
                if (pageNumber == 0) {
                    $('#flipbook').turn('page', 1);
                } else {
                    $('#flipbook').turn('page', pageNumber);
                }
            };
        });

        // N??t ??i???u h?????ng chuy???n trang
        $('#next').click(() => {
            $('#flipbook').turn('next');
            let pageNumb = $('#flipbook').turn('page');
        })
        $('#previous').click(() => {
            $('#flipbook').turn('previous');
            let pageNumb = $('#flipbook').turn('page');
        })


        // thanh progress
        $('#myRange').on('input', function() {
            let x = $('#myRange').val();
            if (x == 0) {
                x = 1;
            }
            changeRange(x)
            $('#flipbook').turn('page', x)
        });


        $("#flipbook").bind("turned", function(event, page, view) {
            $('#slider-value').html(view.join('-'))
            changeRange(page);
            $('#myRange').val(page);
        });
        // thanh progress
        function changeRange(x) {
            let pageTotal = $('.page-total').text();
            let perce = (x) / pageTotal * 100;
            let color = 'linear-gradient(90deg,rgb(66,91,168)' + perce + '%, rgb(214,214,214)' + perce + '%)';
            $('#myRange').css('background', color);
        }
        changeRange(1)

        // An nut trai phai tren ban phim

        $(document).keydown(function(e) {

            var previous = 37,
                next = 39,
                esc = 27;

            switch (e.keyCode) {
                case previous:

                    // left arrow
                    $('#flipbook').turn('previous');
                    e.preventDefault();

                    break;
                case next:

                    //right arrow
                    $('#flipbook').turn('next');
                    e.preventDefault();

                    break;
                    // case esc:

                    //     $('#flipbook-viewport').zoom('zoomOut');	
                    //     e.preventDefault();

                    // break;
            }
        });


        /**
         * Ki???m tra xem trang ???? c?? bookmark hay ch??a 
         * L??m sao ????? ki???m tra???
         * TH1: Khi trang kh??ng chuy???n trang 
         *      - Truy???n v??o s??? trang hi???n t???i 
         *      - G???i ajax n???u trang hi???n t???i ???? bookmark th?? hi???n th??? bookmark full m??u
         * TH2: Khi trang chuy???n trang
         *      - D??ng khi l???ng nghe s??? ki???n turn
         * => T???o h??m d??ng chung cho c??? 2 tr?????ng h???p
         */
        const checkPageHasBookMark = function(page) {
            bookImageList = [...bookImageList]
            bookImageList.map((item, index) => {
                if (page === (index + 1)) {
                    let bookGalleryId = $(item).attr('data-id');
                    console.log(bookGalleryId)
                    $.ajax({
                        url: '/api/check-bookmark',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            page: bookGalleryId,
                            book_slug: '{{{$book->slug}}}',
                            user_id: "{{{Auth::user()->id}}}"
                        },
                        success: function(data) {

                            if (data) {
                                $('.topbar-tool__bookmark i').removeClass('far');
                                $('.topbar-tool__bookmark i').addClass('fas');
                            } else {
                                $('.topbar-tool__bookmark i').removeClass('fas');
                                $('.topbar-tool__bookmark i').addClass('far');
                            }
                        }
                    })
                }
            })

        }
        // Trang ban ?????u
        let initialPage = $('#flipbook').turn('page');
        checkPageHasBookMark(initialPage);


        $("#flipbook").bind("turn", function() {
            let page = $('#flipbook').turn('page');
            checkPageHasBookMark(page);

        });


        /**
         * ????nh d???u trang ???? ?????c v???i n???i d??ng c???n l??u l???i
         * Gi??p ng?????i d??ng c?? th??? xem l???i m???t c??ch d??? d??ng
         */
        $('.topbar-tool__bookmark').click(e => {
            e.preventDefault();
            let page = $('#flipbook').turn('page');


            bookImageList = [...bookImageList]
            bookImageList.map((item, index) => {
                if (page === (index + 1)) {
                    let bookGalleryId = $(item).attr('data-id');
                    $.ajax({
                        url: '/api/check-bookmark',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            page: bookGalleryId,
                            book_slug: '{{{$book->slug}}}',
                            user_id: "{{{Auth::user()->id}}}"
                        },
                        success: function(data) {
                            console.log(data);
                            if (data) {



                                $.ajax({
                                    url: '/api/remove-bookmark',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        page: bookGalleryId,
                                        book_slug: '{{{$book->slug}}}',
                                        user_id: "{{{Auth::user()->id}}}"
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        $('.topbar-tool__bookmark i').removeClass('fas');
                                        $('.topbar-tool__bookmark i').addClass('far');
                                        toast({
                                            message: data.message,
                                            type: "error",
                                            duration: 2000
                                        });
                                    }
                                })
                            } else {



                                $.ajax({
                                    url: '/api/add-bookmark',
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        page: bookGalleryId,
                                        book_slug: '{{{$book->slug}}}',
                                        user_id: "{{{Auth::user()->id}}}"
                                    },
                                    success: function(data) {

                                        $('.topbar-tool__bookmark i').removeClass('far');
                                        $('.topbar-tool__bookmark i').addClass('fas');
                                        toast({
                                            message: data.message,
                                            type: "success",
                                            duration: 2000
                                        });
                                    }
                                })
                            }
                        }
                    })
                }
            })
        })

        /** 
         * Hi???n danh s??ch bookmark
         */

        $('.topbar-tool__list').click(e => {
            e.stopPropagation();
            e.preventDefault();
            topBarBookMark.toggleClass('hidden');
            topbarAside.addClass('hidden');
            $('.dropdown-search').removeClass('active');

            $.ajax({
                url: '/api/list-bookmark',
                method: 'Post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    book_slug: '{{{$book->slug}}}',
                    user_id: "{{{Auth::user()->id}}}"
                },
                success: function(data) {
                    let page = $('#flipbook').turn('page');
                    bookImageList = [...bookImageList]

                    const bookmarks = [...data];
                    console.log(bookmarks);
                    const result = bookmarks.map(bookmark => {
                        let pageNum = bookImageList.findIndex((item) =>
                            $(item).attr('data-id') == bookmark.page
                        )
                        return `<div class="topbar-bookmark__body" data-page = "${pageNum+1}">
                                    <div class="topbar-bookmark__page">
                                        <a href="javascript:void(0)" class="js-bookmark-turn" >
                                            <img src="${bookmark.book_gallery.url}" alt="">
                                        </a>
                                    </div>
                                    <div class="topbar-bookmark__content">
                                        <div class="topbar-content__page">
                                            <a href="javascript:void(0)" class="js-bookmark-turn">
                                                Trang s??? ${pageNum+1}
                                            </a>
                                        </div>
                                        <div class="topbar-content__time">
                                            ${moment(bookmark.created_at).fromNow()}
                                        </div>
                                    </div>
                                    <div class="topbar-bookmark__button">
                                        <a href="" class="topbar-bookmark__button-link" data-page="${bookmark.page}">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                    </div>
                                </div>`
                    }).join('');
                    $('.topbar-bookmark__content-wrap').empty();
                    $('.topbar-bookmark__content-wrap').append(result);
                    $('.js-bookmark-turn').click(e => {
                        e.preventDefault();
                        getPage = e.target.closest('.topbar-bookmark__body');
                        $('#flipbook').turn('page', $(getPage).attr('data-page'));
                    })

                    $('.topbar-bookmark__button-link').map((index, item) => {
                        $(item).click(e => {
                            e.preventDefault();
                            const bookGalleryId = $(item).attr('data-page');

                            $.ajax({
                                url: '/api/remove-bookmark',
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    page: bookGalleryId,
                                    book_slug: '{{{$book->slug}}}',
                                    user_id: "{{{Auth::user()->id}}}"
                                },
                                success: function(data) {
                                    console.log(data);
                                    $('.topbar-tool__bookmark i').removeClass('fas');
                                    $('.topbar-tool__bookmark i').addClass('far');
                                    item.closest('.topbar-bookmark__body').remove();
                                    toast({
                                        message: data.message,
                                        type: "error",
                                        duration: 2000
                                    });
                                }
                            })
                        })
                    })
                }
            })
        });

        // D???u X ??? trong aside book mark list
        // B???m v??o d???u x t???t aside 
        topBarBookMarkIcon.click(e => {

            e.preventDefault();
            topBarBookMark.addClass('hidden');
        });
        topBarBookMark.click(e => e.stopPropagation());





        // B???m v??o b???t k?? ????u t???t aside
        $('body').click((event) => {
            if (!topbarAside.hasClass('hidden')) {

                topbarAside.addClass('hidden');
            }
            if (!topBarBookMark.hasClass('hidden')) {

                topBarBookMark.addClass('hidden');
            }
            if ($('.dropdown-search').hasClass('active')) {
                $('.dropdown-search').removeClass('active');
            }
        })



        // Toast function
        function toast({
            title = "",
            message = "",
            type = "info",
            duration = 3000
        }) {
            const main = document.getElementById("toast");
            if (main) {
                const toast = document.createElement("div");

                // Auto remove toast
                const autoRemoveId = setTimeout(function() {
                    main.removeChild(toast);
                }, duration + 1000);

                // Remove toast when clicked
                toast.onclick = function(e) {
                    if (e.target.closest(".toast__close")) {
                        main.removeChild(toast);
                        clearTimeout(autoRemoveId);
                    }
                };

                const icons = {
                    success: "fas fa-check-circle",
                    info: "fas fa-info-circle",
                    warning: "fas fa-exclamation-circle",
                    error: "fas fa-exclamation-circle"
                };
                const icon = icons[type];
                const delay = (duration / 1000).toFixed(2);

                toast.classList.add("toast", `toast--${type}`);
                toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

                toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast__body">
                        <p class="toast__msg">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="fas fa-times"></i>
                    </div>
                `;
                main.appendChild(toast);
            }
        }



        let initialWidth = $(window).width();
        console.log(initialWidth);
        if (initialWidth <= 1139) {
            $('#flipbook').width('450px');
            $('#flipbook').height('630px');
            $('#flipbook').turn('display', 'single')

        }
        if (initialWidth <= 768) {
            $('#flipbook').width('375px');
            $('#flipbook').height('530px');
            $('#flipbook').turn('display', 'single')

        }
        if (initialWidth <= 375) {
            $('#flipbook').width('200px');
            $('#flipbook').height('282px');
            $('#flipbook').turn('display', 'single')

        }

        $(window).resize(function() {

            var width = $(window).width();
            console.log(width);
            if (width <= 1139) {
                $('#flipbook').width('450px');
                $('#flipbook').height('630px');
                $('#flipbook').turn('display', 'single')

            }
            if (width <= 768) {
                $('#flipbook').width('375px');
                $('#flipbook').height('530px');
                $('#flipbook').turn('display', 'single')

            }
            if (width <= 375) {
                $('#flipbook').width('200px');
                $('#flipbook').height('282px');
                $('#flipbook').turn('display', 'single')

            }
            // if (width <= 768) {
            //     $('.left, .right').addClass('responsive_768');
            // } else {
            //     $('.left, .right').removeClass('responsive_768');
            // }
        });
    </script>
</body>

</html>