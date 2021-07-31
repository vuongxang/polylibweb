<header class="header">
    <div class="header__logo">
        <a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img"></a>
    </div>
    <ul class="header__nav">
        <li class="header__nav-li"><a class="link" href="{{route('home')}}">Trang Chủ</a></li>
        <li class="header__nav-li"><a class="link" href="{{route('book.categories')}}">Danh Mục</a></li>
        <li class="header__nav-li"><a class="link" href="">Tin Tức</a></li>
    </ul>
    <div class="header__search">
        <form action="{{route('search')}}" method="Get" class="search-form" autocomplete="off">
            <input class="search-input" name="keyword" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="search__dropdown hidden" id="js-search__dropdown">
            <div class="search-dropdown__heading">
                Sách
            </div>
            
            <ul class="search-dropdown__ul " id="js-search-dropdown__ul">


            </ul>
        </div>
    </div>
    <div class="header__information">

        @guest
        @if (Route::has('login'))
        <a class=" btn--login" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
        @endif
        @else
        <div class="header__information-notification ">

            <!-- Nav Item - Alerts -->
            <div class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">3+</span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 12, 2019</div>
                            <span class="font-weight-bold">A new monthly report is ready to download!</span>
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-success">
                                <i class="fas fa-donate text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 7, 2019</div>
                            $290.29 has been deposited into your account!
                        </div>
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-warning">
                                <i class="fas fa-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">December 2, 2019</div>
                            Spending Alert: We've noticed unusually high spending for your account.
                        </div>
                    </a>
                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                </div>
            </div>
        </div>
        <div>
            <a id="navbarDropdown" class="nav-link  header__information-info" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img src="{{Auth::user()->avatar}}" alt="">
                <i class="fas fa-caret-down"></i>
            </a>
            @if (Auth::check())
            <div class="dropdown-menu dropdown-menu-right dropdown-custom" aria-labelledby="navbarDropdown">
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <a class="dropdown-item dropdown-item-custom" href="{{ route('dashboard') }}">
                    <i class="fas fa-users-cog"></i>Quản trị
                </a>
                @endif
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.setting') }}">
                    <i class="fas fa-cog"></i>Cài đặt
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.infomation', Auth::user()->id) }}">
                    <i class="fas fa-user"></i>Hồ sơ cá nhân
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                    <i class="fas fa-history"></i>Lịch sử mượn sách
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.rate', Auth::user()->id) }}">
                    <i class="fas fa-star"></i>Đánh giá
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.help') }}">
                    <i class="fas fa-headphones-alt"></i>Trợ giúp
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>{{ __('Đăng xuất') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            @endif
        </div>
        @endguest
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<script>
    $(function($) {
        let timer;
        let keyword = $('input[name= "keyword"]');
        $('.container-custom').click(() => {
            $('#js-search-dropdown__ul').parent().addClass('hidden');
        })
        $('#js-search__dropdown').click((e) => {
            e.stopPropagation();
        })
        $(document).on({
            ajaxStart: function() {
                console.log('Loading...')
                $('#js-search-dropdown__ul').append(
                    ` <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>`
                )
            },
            ajaxStop: function() {
                $('.lds-ellipsis').remove()
            }
        });
        keyword.on('input', function(e) {

            // if (e.which <= 90 && e.which >= 48) {
            //     console.log('hello');
            // }
            if (keyword.val().trim().length == 0 || keyword.val().length == 0 ) return;
            if (keyword.val().trim().length > 1 ) {
                console.log(keyword.val().trim());
                $('#js-search-dropdown__ul').parent().removeClass('hidden');
                $('#js-search-dropdown__ul').empty();
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{route("searchapi")}}',
                        method: "post",
                        data: {
                            keyword: keyword.val()
                        },
                        dataType: 'json',
                        success: function(res) {
                            if (res.length >0) {
                                console.log(res)
                                searchBookResult = [...res];
                                const results = searchBookResult.map((item) => {
                                    return `<li class="search-dropdown__li">
                                            <a href="/book-detail/${item.id}" class="search-dropdown__link">
                                                <div class="book-card-horizontal">
                                                    <div class="book-card-cover-image">
                                                        <img src="${item.image}" alt="">
                                                    </div>
                                                    <div class="book-search-info">
                                                        <div class="book-search-info__title">${item.title}</div>
                                                        <div class="book-search-info__author">
                                                        ${item.authors.map(item=>{return `${item.name}`})}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>`
                                }).join("");

                                $('#js-search-dropdown__ul').append(results);
                            }
                            else{
                                $('#js-search-dropdown__ul').append(`<div class="search-dropdown__status">Không tìm thấy kết quả nào cho từ khóa ${keyword.val()}</div>
                                `);
                            }
                        }
                    })
                }, 500);
            }
        })
    })
</script>