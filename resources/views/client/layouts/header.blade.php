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
        <form action="{{route('search')}}" method="Get" class="search-form">
            <input class="search-input" name="keyword" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
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
        <div class="header__information-notification ">

            <!-- Nav Item - Alerts -->
            <div class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">
                        @if (auth()->user()->unreadNotifications->count()<=3)
                            {{auth()->user()->unreadNotifications->count()}}
                        @else
                            3+
                        @endif
                    </span>
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" id="menu_notification" aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Alerts Center
                    </h6>
                    @foreach (Auth::user()->notifications as $notification)
                        <a class="dropdown-item d-flex align-items-center" href="{{route('notification.read',$notification->id)}}">
                            <div class="mr-3">
                                <div class="icon-circle">
                                    @if ($notification->read_at==null)
                                        <i class="fas fa-file-alt text-white"></i>
                                    @else
                                        <i class="fas fa-check text-success bg-white"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="@if ($notification->read_at==null) font-weight-bold @endif">
                                <div class="small text-gray-500">{{ $notification->data['title'] }}</div>
                                <span class="">{{ $notification->data['content'] }}</span>
                            </div>
                        </a>
                    @endforeach
                    {{-- <a class="dropdown-item d-flex align-items-center" href="#">
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
                    </a> --}}
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
                <!-- <a class="dropdown-item dropdown-item-custom" href="{{ route('user.setting') }}">
                    <i class="fas fa-cog"></i>Cài đặt
                </a> -->
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.infomation', Auth::user()->id) }}">
                    <i class="fas fa-user"></i>Hồ sơ cá nhân
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                    <i class="fas fa-history"></i>Lịch sử mượn sách
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.rate', Auth::user()->id) }}">
                    <i class="fas fa-star"></i>Đánh giá
                </a>
                <!-- <a class="dropdown-item dropdown-item-custom" href="{{ route('user.help') }}">
                    <i class="fas fa-headphones-alt"></i>Trợ giúp
                </a> -->
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