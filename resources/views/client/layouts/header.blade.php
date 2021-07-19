<header class="header">
    <div class="header__logo">
        <a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img"></a>
    </div>
    <ul class="header__nav">
        <li class="header__nav-li"><a class="link" href="{{route('home')}}">Trang Chủ</a></li>
        <li class="header__nav-li"><a class="link" href="{{route('book.detail',1)}}">Danh Mục</a></li>
        <li class="header__nav-li"><a class="link" href="">Tin Tức</a></li>
    </ul>
    <div class="header__search">
        <form action="" class="search-form">
            <input class="search-input" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="header__information">

        @guest
        @if (Route::has('login'))
        <a class=" btn--login" href="{{ route('login') }}">{{ __('Đăng nhập') }}</a>
        @endif
        @else
        <div class="header__information-notification">
            <img src="{{asset('images/notification.svg')}}" alt="">
        </div>
        <a id="navbarDropdown" class="nav-link  header__information-info" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <img src="{{Auth::user()->avatar}}" alt="">
            <i class="fas fa-caret-down"></i>
        </a>
        @if (Auth::check())
            <div class="dropdown-menu dropdown-menu-right dropdown-custom" aria-labelledby="navbarDropdown">
                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <a class="dropdown-item dropdown-item-custom" href="{{ route('dashboard') }}">
                    <img src="{{asset('images/admin-icon.svg')}}" alt="">Quản trị
                </a>
                @endif
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.infomation', Auth::user()->id) }}">
                    <img src="{{asset('images/user-icon.svg')}}" alt="">Hồ sơ cá nhân
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                    <img src="{{asset('images/history-icon.svg')}}" alt="">Lịch sử mượn sách
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                    <img src="{{asset('images/logout-icon.svg')}}" alt="">{{ __('Đăng xuất') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endif

        @endguest
    </div>
</header>