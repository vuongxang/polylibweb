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
            <input class="search-input" name="keyword" type="text" placeholder="Tìm kiếm theo tên sách, tác giả" value="{{ old('keyword') }}">
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
            <div class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    <span class="badge badge-danger badge-counter">
                        @if (auth()->user()->unreadNotifications->count()<=3) {{auth()->user()->unreadNotifications->count()}} @else 3+ @endif </span>
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

        /**
         * Bắt sự kiện click vào layout tắt dropdown
         * Và bắt nổi bọt khi bấm vào dropdown
         */

        $('.container-custom').click(() => {
            $('#js-search__dropdown').addClass('hidden');
        })
        $('#js-search__dropdown').click((e) => {
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
                            if (res.length > 0) {
                                searchBookResult = [...res[0]];
                                searchAuthorResult = [...res[1]];
                                console.log(searchAuthorResult)
                                if (searchBookResult.length > 0) {
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
                                    const authorsResult = searchAuthorResult.map((item,index) => {
                                        if (index < 3) {
                                            return `<li class="search-dropdown__li">
                                                <a href="/book-detail/${item.id}" class="search-dropdown__link">
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
                        }
                    })
                }
            }, 500);
        })
    })
</script>