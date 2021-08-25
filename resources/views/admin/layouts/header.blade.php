<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <form action="" method="get">
                <input type="text" class="form-control bg-light border-0 small" name="keyword" placeholder="Nhập từ khóa tìm kiếm" aria-label="Search" aria-describedby="basic-addon2" value="@isset($_GET['keyword']) {{$_GET['keyword']  }}@endisset">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge rounded-pill badge-danger badge-counter" id="unread-notify">{{count(Auth::user()->unreadNotifications)}}</span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in " aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header bg-dark border-0">
                    Thông báo
                </h6>
                <div id="notification-dropdown-body">
                    @if(count(Auth::user()->notifications) == 0)
                    <div class="dropdown-item d-flex align-items-center">
                        <div class="small text-gray-700"> Bạn chưa có thông báo mới</div>
                    </div>
                    @endif
                    @if(count(Auth::user()->notifications) > 0)
                    @foreach (Auth::user()->notifications as $key => $notification)
                    @if($key==3) @break
                    @endif
                    <a class="dropdown-item d-flex align-items-center notification-dropdown__link" href="/admin/comment#menu1">
                        <div class="mr-2">
                            <img class="img-profile rounded-circle " style="width:3.5rem;height:3.5rem" src="{{ asset($notification->data['avatar']) }}" alt="">
                        </div>
                        <div>
                            <div class="small text-gray-700">{{ $notification->data['title'] }}</div>
                            <span class="font-weight-bold">{!! $notification->data['content'] !!}</span>
                            <div class="small text-primary ">{{ Carbon\Carbon::parse($notification->created_at)->locale('vi')->diffForHumans() }}</div>
                        </div>
                    </a>
                    @endforeach
                    @endif

                </div>
                <a class="dropdown-item text-center small font-weight-bold text-gray-800" href="{{route('admin.notifications')}}">Xem tất cả</a>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{Auth::user()->name}}
                </span>
                <img class="img-profile rounded-circle" src="{{asset(Auth::user()->avatar)}}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{route('user.profile',Auth::user()->id)}}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Hồ sơ cá nhân
                </a>
                <!-- <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a> -->
                
                <a class="dropdown-item" href="{{route('admin.notifications')}}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Thông báo
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Đăng xuất
                </a>
            </div>
        </li>

    </ul>

</nav>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script>
    $(function($) {
        moment.locale('vi');
        let AuthUser = "{{{ (Auth::user()) ? Auth::user()->id : null }}}";
        if (AuthUser) {
            Echo.private(`notification.${AuthUser}`)

                .listen('NewNotificationEvent', (e) => {
                    notification = e.notification;
                    notificationData = e.notification['data'];

                    const result = `<a class="dropdown-item d-flex align-items-center notification-dropdown__link" href="/admin/comment#menu1">
                                        <div class="mr-1">
                                            <img class="img-profile rounded-circle w-75"  src="${notificationData.avatar}"  alt="">
                                        </div>
                                        <div>
                                            <div class="small text-gray-700">${notificationData.title}</div>
                                            <span class="font-weight-bold ">${notificationData.content}</span>
                                            <div class="small text-primary ">${moment(notification.created_at).fromNow()}</div>
                                        </div>
                                    </a>
                                `
                    $('#unread-notify').html(e.unreadNotify);
                    $('#notification-dropdown-body').prepend(result);
                    console.log()
                    if ($('.notification-dropdown__link').length > 3) {
                        $('.notification-dropdown__link')[3].remove();


                    }

                })

        }
    })
</script>