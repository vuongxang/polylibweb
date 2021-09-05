<header class="header grid-custom-mobile">
    <div class="header-mobile">
        <div class="header-mobile__logo">
            <a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img"></a>
        </div>
        <div class="header-mobile__function">
            <div class="toggle-cate ">
                <i class="fas fa-bars toggle-icon"></i>
                <div class="header-menu__cate">
                    <ul class="header-mobile__nav">
                        <li class="header__nav-li"><a class="link" href="{{route('home')}}"><i class="fas fa-home"></i>Trang Chủ</a></li>
                        <li class="header__nav-li"><a class="link" href="{{route('book.categories')}}"><i class="fas fa-bars"></i>Danh Mục</a></li>
                        <li class="header__nav-li"><a class="link" href="{{route('post')}}"><i class="fas fa-file-signature"></i>Bài Viết</a></li>
                        <li class="header__nav-li"><a class="link" href="{{route('contact')}}"><i class="fas fa-id-badge"></i>Liên Hệ</a></li>
                    </ul>
                </div>
            </div>
            <!-- search -->
            <div class="toggle-search">
                <div class="click-search">
                    <i class="fas fa-search toggle-icon"></i>
                </div>
                <div class="search-hiden">
                    <form action="{{route('search')}}" method="Get" class="search-form" autocomplete="off">
                        <input class="search-txt" name="keyword" type="text" placeholder="Tìm kiếm" value="@isset($_GET['keyword']){{$_GET['keyword']}}@endisset">
                        <a class="search-btn" href="#">
                            <i class="fas fa-search search-icon"></i>
                        </a>
                    </form>
                </div>

            </div>
            <!-- end search -->
            <!-- notification -->
            <div class="notification ">
                @guest
                @if (Route::has('login'))
                <a class="" href="#"><i class="fas fa-bell toggle-icon"></i></a>
                @endif
                @else
                <div class="header-menu__users">
                    <div class="header__information-notification ">
                        <!-- Nav Item - Alerts -->
                        <div class="header-notification" id="header-notification-mobile">
                            <button class=" header-notification__bell" id="alertsDropdown-mobile">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->

                                <span class="badge badge-danger badge-counter" id="unread-notify">
                                    {{auth()->user()->unreadNotifications->count()}}
                                </span>
                            </button>

                            <!-- Dropdown - Alerts -->
                            <div class="hidden " id="menu_notification-mobile" aria-labelledby="alertsDropdown-mobile">
                                <div class="notification-dropdown-header">
                                    <div class="notification-header__title">Thông báo</div>
                                    <div class="notification-header__more"><a href="{{route('notifications.read')}}">Đánh dấu tất cả là đã đọc</a></div>
                                </div>
                                <div class="notification-dropdown-body">
                                    @if(count(Auth::user()->notifications) == 0)
                                    <div id="notification-message"> Bạn chưa có thông báo mới</div>
                                    @endif
                                    @if(count(Auth::user()->notifications) > 0)

                                    @foreach (Auth::user()->notifications as $key => $notification)
                                    @if($key==5) @break
                                    @endif
                                    <div class=" notification-dropdown">
                                        <a class="notification-dropdown__link" href="{{route('notification.read',$notification->id)}}">
                                            <div class="notification-dropdown-wrapper">

                                                <div class="notification-avatar">
                                                    <img src="{{$notification->data['avatar']}}" alt="">

                                                </div>
                                                <div class=" notification-body">
                                                    <div class="notification-body__content ">{{ $notification->data['content'] }}</div>
                                                    <span class="notification-body__time ">{{ Carbon\Carbon::parse($notification->created_at)->locale('vi')->diffForHumans() }}</span>
                                                </div>
                                                <div class=" notification-icon">
                                                    @if ($notification->read_at==null)
                                                    <!-- <i class="fas fa-file-alt text-white"></i> -->
                                                    <i class="fas fa-circle"></i>
                                                    @else
                                                    <i class="fas fa-check "></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                    @endforeach
                                    @endif


                                </div>
                                <a class="load-more__notification" href="{{route('notifications')}}">Xem tất cả </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endguest
            </div>
            <!-- end notification -->
            <div class="toggle-user ">
                @guest
                @if (Route::has('login'))
                <a class="" href="{{ route('login') }}"><i class="fa fa-sign-in-alt toggle-icon"></i></a>
                @endif
                @else
                <div class="header-menu__users">
                    <div class="inf-user">
                        <a class="nav-link header__information-info" href="#">
                            <img src="{{Auth::user()->avatar}}" alt="">
                        </a>
                    </div>
                </div>
                @endguest
                <!-- <div class="header-menu__user"> -->
                <div class="header-mobile__information">
                    @guest
                    @if (Route::has('login'))
                    @endif
                    @else
                    <div>
                        @if (Auth::check())
                        <a class="dropdown-item dropdown-item-custom" href="{{ route('client.profile', Auth::user()->id) }}">
                        <i class="fas fa-user"></i>Hồ sơ cá nhân
                    </a>
                    <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                        <i class="fas fa-history"></i>Lịch sử mượn sách
                    </a>
                    <a class="dropdown-item dropdown-item-custom" href="{{route('user.myPost',Auth::user()->id)}}">
                        <i class="fas fa-history"></i>Bài viết của tôi
                    </a>
                    <a class="dropdown-item dropdown-item-custom" href="{{ route('user.rate', Auth::user()->id) }}">
                        <i class="fas fa-star"></i>Đánh giá
                    </a>
                    <a class="dropdown-item dropdown-item-custom" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form-mobile').submit();">
                        <i class="fas fa-sign-out-alt"></i>{{ __('Đăng xuất') }}
                    </a>

                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                        @endif
                    </div>
                    @endguest
                 

                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>

</header>
<header class="header header-desktop">

    <div class="header__logo">
        <a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img"></a>
    </div>

    <ul class="header__nav">
        <li class="header__nav-li"><a class="link {{request()->is('/') ? 'active' : '' }}" href="{{route('home')}}">Trang Chủ</a></li>
        <li class="header__nav-li"><a class="link {{request()->is('category') ? 'active' : '' }}" href="{{route('book.categories')}}">Danh Mục</a></li>
        <li class="header__nav-li"><a class="link {{request()->is('post') ? 'active' : '' }}" href="{{route('post')}}">Bài Viết</a></li>
        <li class="header__nav-li"><a class="link {{request()->is('contact') ? 'active' : '' }}" href="{{route('contact')}}">Liên Hệ</a></li>
    </ul>
    <div class="header__search">
        <form action="{{route('search')}}" method="Get" class="search-form" autocomplete="off">
            <input class="search-input" name="keyword" id="js-header-search-desktop" type="text" placeholder="Tìm kiếm theo tên sách, tác giả" value="@isset($_GET['keyword']){{$_GET['keyword']}}@endisset">
            <button class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <div class="search__dropdown hidden" id="js-search__dropdown">
            <div class="search-dropdown__categories">

                <div class="search-dropdown__heading">
                    Sách
                </div>

                <ul class="search-dropdown__ul " id="js-search-dropdown__ul--cate">


                </ul>
            </div>
            <div class="search-dropdown__authors">

                <div class="search-dropdown__heading">
                    Tác Giả
                </div>

                <ul class="search-dropdown__ul " id="js-search-dropdown__ul--author">

                </ul>

            </div>
            <div class="search-dropdown__posts">

                <div class="search-dropdown__heading">
                    Bài Viết
                </div>

                <ul class="search-dropdown__ul " id="js-search-dropdown__ul--post">

                </ul>

            </div>
            <a class="load-more__notification js-search-all" href="javascript:void(0)">Xem tất cả </a>
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
            <div class="header-notification" id="header-notification">
                <button class=" header-notification__bell" id="alertsDropdown">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    {{-- && Auth::user()->role->id != 1 && Auth::user()->role->id != 2 --}}
                    <span class="badge badge-danger badge-counter" id="unread-notify">
                        {{auth()->user()->unreadNotifications->count()}}</span>
                </button>

                <!-- Dropdown - Alerts -->
                <div class="hidden " id="menu_notification" aria-labelledby="alertsDropdown">
                    <div class="notification-dropdown-header">
                        <div class="notification-header__title">Thông báo</div>
                        <div class="notification-header__more"><a href="{{route('notifications.read')}}">Đánh dấu tất cả là đã đọc</a></div>
                    </div>
                    <div class="notification-dropdown-body">
                        @if(count(Auth::user()->notifications) == 0)
                        <div id="notification-message"> Bạn chưa có thông báo mới</div>
                        @endif
                        @if(count(Auth::user()->notifications) > 0)

                        @foreach (Auth::user()->notifications as $key => $notification)
                        @if($key==5) @break
                        @endif
                        <div class=" notification-dropdown">
                            <a class="notification-dropdown__link" href="{{route('notification.read',$notification->id)}}">
                                <div class="notification-dropdown-wrapper">

                                    <div class="notification-avatar">
                                        <img src="{{asset($notification->data['avatar'])}}" alt="">

                                    </div>
                                    <div class=" notification-body">
                                        <div class="notification-body__content ">{{ $notification->data['content'] }}</div>
                                        <span class="notification-body__time ">{{ Carbon\Carbon::parse($notification->created_at)->locale('vi')->diffForHumans() }}</span>
                                    </div>
                                    <div class=" notification-icon">
                                        @if ($notification->read_at==null)
                                        <!-- <i class="fas fa-file-alt text-white"></i> -->
                                        <i class="fas fa-circle"></i>
                                        @else
                                        <i class="fas fa-check "></i>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>

                        @endforeach
                        @endif


                    </div>
                    <a class="load-more__notification" href="{{route('notifications')}}">Xem tất cả </a>
                </div>
            </div>
        </div>
        <div>
            <a id="navbarDropdown" class="nav-link  header__information-info" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <img src="{{asset(Auth::user()->avatar)}}" alt="">
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
                <a class="dropdown-item dropdown-item-custom" href="{{ route('client.profile', Auth::user()->id) }}">
                    <i class="fas fa-user"></i>Hồ sơ cá nhân
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                    <i class="fas fa-history"></i>Lịch sử mượn sách
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{route('user.myPost',Auth::user()->id)}}">
                    <i class="fas fa-address-book"></i>Bài viết của tôi
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>


<script>
    $(function($) {
        moment.locale('vi');
        let timer; // Sau thời gian 5 giây khi bấm vào ô input thì mới bắt đầu tìm kiếm đỡ phải gọi ajax quá nhiều
        let keyword = $('#js-header-search-desktop');
        let AuthUser = "{{{ (Auth::user()) ? Auth::user()->id : null }}}";

        /** 
         * Sử dụng Echo Package để gửi thông báo Real Time 
         * Thư viện có sẵn với laravel nên có tài liệu đọc 
         */
        if (AuthUser) {

            Echo.private(`notification.${AuthUser}`)

                .listen('NewNotificationEvent', (e) => {
                    notification = e.notification;
                    notificationData = e.notification['data'];
                    const result = `<a class="notification-dropdown__link" href="/notification-read/${notification.id}">
                                    <div class="notification-dropdown-wrapper">

                                        <div class="notification-avatar">
                                            <img src="${asset(notificationData.avatar)}" alt="">

                                        </div>
                                        <div class=" notification-body">
                                            <div class="notification-body__content ">${notificationData.content}</div>
                                            <span class="notification-body__time ">${moment(notification.created_at).fromNow()}</span>
                                        </div>
                                        <div class=" notification-icon">
                                        <i class="fas fa-circle"></i>
                                        
                                    </div>
                                    </div>
                                </a>

                                `
                    $('#unread-notify').html(e.unreadNotify);
                    $('.notification-dropdown-body').prepend(result);
                    if ($('.notification-dropdown__link').length > 5) {
                        $('.notification-dropdown__link')[5].remove();
                    }
                    if ($('#notification-message')) {
                        $('#notification-message').remove();
                    }

                })

        }
        /**
         * Bắt sự kiện click vào layout tắt dropdown tìm kiếm và thông báo
         * Và bắt nổi bọt khi bấm vào dropdown tìm kiếm và thông báo
         */


        $('.js-search-all').click(() => {

            window.location = `/search?keyword=${keyword.val()}`;
        })
        // console.log(keyword);
        $('.container-custom').click(() => {
            $('#js-search__dropdown').addClass('hidden');
            $('#menu_notification').addClass('hidden');

        })

        $('#js-search__dropdown').click((e) => {
            e.stopPropagation();
        })
        $('#alertsDropdown').click((e) => {
            e.stopPropagation();
            if ($('#menu_notification').hasClass('hidden')) {
                $('#menu_notification').removeClass('hidden');
            } else {
                $('#menu_notification').addClass('hidden');
            }
        })
        $('#menu_notification').click(e => {
            e.stopPropagation();
        })

        /** 
         * Loading danh mục
         */
        $(document).on({
            ajaxStart: function() {
                $('#js-search-dropdown__ul--cate').append(
                    ` <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>`
                )
                $('#js-search-dropdown__ul--author').append(
                    ` <div class="lds-ellipsis">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>`
                )
                $('#js-search-dropdown__ul--post').append(
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

        /** 
         * Bắt sự kiện khi nhập ô input 
         * Gọi ajax và đổ dữ liệu ra dropdown
         */
        keyword.on('input', function(e) {

            // console.log(keyword.val().length);

            // if (e.which <= 90 && e.which >= 48) {
            //     console.log('hello');
            // }
            if (keyword.val().trim().length == 0 || keyword.val().length <= 1) {
                $('#js-search__dropdown').addClass('hidden')
            };
            clearTimeout(timer);
            timer = setTimeout(function() {
                if (AuthUser) {

                    if (keyword.val() && keyword.val().trim().length > 1 && keyword.val().length > 1) {
                        // console.log(keyword.val().trim().length);
                        $('#js-search__dropdown').removeClass('hidden');
                        $('#js-search-dropdown__ul--cate').empty();
                        $('#js-search-dropdown__ul--author').empty();
                        $('#js-search-dropdown__ul--post').empty();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: '{{route("searchapi")}}',
                            method: "post",
                            data: {
                                keyword: keyword.val(),

                            },
                            dataType: 'json',
                            success: function(res) {
                                // console.log(res.status)
                                if (res.length > 0) {
                                    searchBookResult = [...res[0]];
                                    searchAuthorResult = [...res[1]];
                                    searchPostResult = [...res[2]];
                                    if (searchBookResult.length > 0) {
                                        // console.log(searchBookResult);
                                        const booksResult = searchBookResult.map((item, index) => {
                                            if (index < 3) {
                                                return `<li class="search-dropdown__li">
                                            <a href="/book-detail/${item.slug}" class="search-dropdown__link">
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
                                            }
                                        }).join("");
                                        $('#js-search-dropdown__ul--cate').html(booksResult);
                                    } else {
                                        $('#js-search-dropdown__ul--cate').html(`<div class="search-dropdown__status">Không tìm thấy kết quả nào cho từ khóa ${keyword.val()}</div>`);
                                    }
                                    if (searchAuthorResult.length > 0) {
                                        const authorsResult = searchAuthorResult.map((item, index) => {
                                            if (index < 3) {
                                                return `<li class="search-dropdown__li">
                                                <a href="/author/${item.id}" class="search-dropdown__link">
                                                    <div class="book-card-horizontal">
                                                        <div class="book-card-author-avatar ">
                                                            <img src="${item.avatar}" alt="">
                                                        </div>
                                                        <div class="book-search-info">
                                                            <div class="book-search-info__name">${item.name}</div>
                                                            <div class="book-search-info__dob">${item.date_birth}</div>
                                                            <div class="book-search-info__description">
                                                                ${item.description}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>`
                                            }
                                        }).join("");

                                        $('#js-search-dropdown__ul--author').empty();
                                        $('#js-search-dropdown__ul--author').html(authorsResult);
                                    } else {
                                        $('#js-search-dropdown__ul--author').empty();
                                        $('#js-search-dropdown__ul--author').html(`<div class="search-dropdown__status">Không tìm thấy kết quả nào cho từ khóa ${keyword.val()}</div>`);
                                    }
                                    if (searchPostResult.length > 0) {
                                        const postsResult = searchPostResult.map((item, index) => {
                                            if (index < 3) {
                                                return `<li class="search-dropdown__li">
                                                            <a href="/post-detail/${item.slug}" class="search-dropdown__link">
                                                                <div class="book-card-horizontal">
                                                                    <div class="book-card-post-cover ">
                                                                        <img class = "book-card-post-image"src="/${item.thumbnail}" alt="">
                                                                    </div>
                                                                    <div class="book-search-info">
                                                                        <div class="post-title">${item.title}</div>
                                                                        <div class="created-at">${moment(item.created_at).format("LL")}
                                                                        </div>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li>`
                                            }
                                        }).join("");

                                        $('#js-search-dropdown__ul--post').empty();
                                        $('#js-search-dropdown__ul--post').html(postsResult);
                                    } else {
                                        $('#js-search-dropdown__ul--post').empty();
                                        $('#js-search-dropdown__ul--post').html(`<div class="search-dropdown__status">Không tìm thấy kết quả nào cho từ khóa ${keyword.val()}</div>`);
                                    }
                                } else {
                                    $('#js-search-dropdown__ul--cate').append(`<div class="search-dropdown__status">Không tìm thấy kết quả nào cho từ khóa ${keyword.val()}</div>
                                `);
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {

                            }
                        })


                    }
                } else {
                    window.location = "/login";
                }
            }, 500);

        })

        /**
         * Responsive Mobile Toggle 
         * Khi tạo ra 
         */
        $('#alertsDropdown-mobile').click((e) => {
            e.stopPropagation();
            if ($('#menu_notification-mobile').hasClass('hidden')) {
                $('#menu_notification-mobile').removeClass('hidden');
            } else {
                $('#menu_notification-mobile').addClass('hidden');
            }
        })
        $('.toggle-cate').click(function() {

            $('.header-menu__cate').toggleClass('show-cate');
        })
        $('.inf-user').click(function() {
            $('.header-mobile__information').toggleClass('show-user')
        })
        $('.click-search').click(function() {

            $('.search-hiden').toggleClass('test');

        })
    })
</script>