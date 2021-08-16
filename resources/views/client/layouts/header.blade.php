<header class="header">
    <div class="header__logo">
        <a href="{{route('home')}}"><img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img"></a>
    </div>
    <ul class="header__nav">
        <li class="header__nav-li"><a class="link" href="{{route('home')}}">Trang Chủ</a></li>
        <li class="header__nav-li"><a class="link" href="{{route('book.categories')}}">Danh Mục</a></li>
        <li class="header__nav-li"><a class="link" href="{{route('post.categories')}}">Bài viết</a></li>
    </ul>
    <div class="header__search">
        <form action="{{route('search')}}" method="Get" class="search-form" autocomplete="off">
            <input class="search-input" name="keyword" type="text" placeholder="Tìm kiếm theo tên sách, tác giả" value="@isset($_GET['keyword']) {{$_GET['keyword']  }}@endisset">
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
                    Tác giả
                </div>

                <ul class="search-dropdown__ul " id="js-search-dropdown__ul--author">
                    <!-- <li class="search-dropdown__li">
                        <a href="/book-detail/${item.id}" class="search-dropdown__link">
                            <div class="book-card-horizontal">
                                <div class="book-card-author-avatar ">
                                    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
                                </div>
                                <div class="book-search-info">
                                    <div class="book-search-info__name">The Chew</div>
                                    <div class="book-search-info__dob">1/8/2021</div>
                                    <div class="book-search-info__description">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illum doloremque, similique explicabo nemo tempora non vero aliquam repudiandae inventore ipsa incidunt impedit qui quod culpa officia quis dicta eaque tempore?
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="search-dropdown__li">
                        <a href="/book-detail/${item.id}" class="search-dropdown__link">
                            <div class="book-card-horizontal">
                                <div class="book-card-author-avatar ">
                                    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="">
                                </div>
                                <div class="book-search-info">
                                    <div class="book-search-info__name">The Chew</div>
                                    <div class="book-search-info__dob">1/8/2021</div>
                                    <div class="book-search-info__description">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illum doloremque, similique explicabo nemo tempora non vero aliquam repudiandae inventore ipsa incidunt impedit qui quod culpa officia quis dicta eaque tempore?
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li> -->
                </ul>
            </div>


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
                <a class="dropdown-item dropdown-item-custom" href="{{ route('client.profile', Auth::user()->id) }}">
                    <i class="fas fa-user"></i>Hồ sơ cá nhân
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{ route('user.history', Auth::user()->id) }}">
                    <i class="fas fa-history"></i>Lịch sử mượn sách
                </a>
                <a class="dropdown-item dropdown-item-custom" href="{{route('user.myPost',Auth::user()->id)}}">
                    <i class="fas fa-history"></i>Tài liệu của tôi
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
        let timer;
        let keyword = $('input[name= "keyword"]');
        let AuthUser = "{{{ (Auth::user()) ? Auth::user()->id : null }}}";
        if (AuthUser) {

            Echo.private(`notification.${AuthUser}`)

                .listen('NewNotificationEvent', (e) => {
                    notification = e.notification;
                    notificationData = e.notification['data'];

                    const result = `<a class="notification-dropdown__link" href="/notification-read/${notification.id}">
                                    <div class="notification-dropdown-wrapper">

                                        <div class="notification-avatar">
                                            <img src="${notificationData.avatar}" alt="">

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
         * Bắt sự kiện click vào layout tắt dropdown
         * Và bắt nổi bọt khi bấm vào dropdown
         */

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
                console.log('Loading...')
                $('#js-search-dropdown__ul--cate').append(
                    ` <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>`
                )
                console.log('Loading...')
                $('#js-search-dropdown__ul--author').append(
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

            console.log(keyword.val().length);

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
                        console.log(keyword.val().trim().length);
                        $('#js-search__dropdown').removeClass('hidden');
                        $('#js-search-dropdown__ul--cate').empty();
                        $('#js-search-dropdown__ul--author').empty();
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
                                console.log(res.status)
                                if (res.length > 0) {
                                    searchBookResult = [...res[0]];
                                    searchAuthorResult = [...res[1]];
                                    console.log(searchAuthorResult)
                                    if (searchBookResult.length > 0) {
                                        console.log(searchBookResult);
                                        const booksResult = searchBookResult.map((item, index) => {
                                            if (index < 3) {
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

    })
</script>