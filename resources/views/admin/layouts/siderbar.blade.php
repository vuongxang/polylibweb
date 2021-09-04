<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        
            <img src="{{asset('images/logo.png')}}" alt="" width="70px">
        <div class="sidebar-brand-text mx-3">POLYLIB Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ (request()->is('admin')) ? 'active' : '' }}">
        <a class="nav-link " href="{{route('dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        TÀI NGUYÊN
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ (request()->is('admin/cate*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-list-alt "></i>
            <span>Danh mục sách</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('cate.index')}}">Danh sách</a>
                <a class="collapse-item" href="{{route('cate.create')}}">Thêm mới</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item {{ (request()->is('admin/book*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-book"></i>
            <span>Sách</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Utilities:</h6> --}}
                <a class="collapse-item" href="{{route('book.index')}}">Danh sách</a>
                <a class="collapse-item" href="{{route('book.create')}}">Thêm mới</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/author*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
            aria-expanded="true" aria-controls="collapseThree">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Tác giả</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('author.index')}}">Danh sách</a>
                <a class="collapse-item" href="{{route('author.create')}}">Thêm mới</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/post-cate*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePostCate"
            aria-expanded="true" aria-controls="collapsePostCate">
            <i class="fas fa-fw fa-th"></i>
            <span>Danh mục bài viết</span>
        </a>
        <div id="collapsePostCate" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('postCate.index')}}">Danh sách</a>
                <a class="collapse-item" href="{{route('postCate.create')}}">Thêm mới</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/post-share*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePost"
            aria-expanded="true" aria-controls="collapsePost">
            <i class="fas fa-scroll"></i>
            <span>Bài viết</span>
        </a>
        <div id="collapsePost" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('post.index')}}">Danh sách</a>
                {{-- <a class="collapse-item" href="{{route('postCate.create')}}">Thêm mới</a> --}}
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/file*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSeven"
            aria-expanded="true" aria-controls="collapseSeven">
            <i class="fas fa-fw fa-file"></i>
            <span>Quản lý file</span></a>
        <div id="collapseSeven" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('filemanager')}}">Quản lý file</a>
                <a class="collapse-item" href="{{route('file.convertForm')}}">Convert pdf file</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/comment*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-comments"></i>
            <span>Bình luận - Đánh giá</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('comment.index')}}">Bình luận sách</a>
                <a class="collapse-item" href="{{route('postComment.index')}}">Bình luận bài viết</a>
                <a class="collapse-item" href="{{route('rate.index')}}">Đánh giá</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    @if (Auth::user()->role_id==1)
    <div class="sidebar-heading">
        Tài khoản
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ (request()->is('admin/user')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Tài khoản nhân viên</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('user.index')}}">Tài khoản nhân viên</a>
                <a class="collapse-item" href="{{route('user.create')}}">Thêm mới tài khoản</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ (request()->is('admin/user/client')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('user.client')}}">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Tài khoản người dùng</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('admin/user/mass-lock-user')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{route('user.massLockForm')}}">
            <i class="fas fa-fw fa-lock"></i>
            <span>Nhập file khóa tài khoản</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    @endif
    <div class="sidebar-heading"> 
        Thống kê
    </div>
    <li class="nav-item {{ (request()->is('admin/report*')) ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFive"
            aria-expanded="true" aria-controls="collapseFive">
            <i class="fas fa-chart-area"></i>
            <span>Báo cáo - Thống kê</span>
        </a>
        <div id="collapseFive" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('report.topBorrowBook')}}">Top sách mượn nhiều</a>
                <a class="collapse-item" href="{{route('report.topViewPost')}}">Top bài viết view cao</a>
                <a class="collapse-item" href="{{route('report.topUserPost')}}">Top SV đăng nhiều</a>
                <a class="collapse-item" href="{{route('report.topCatePost')}}">Top danh mục bài viết</a>
            </div>
        </div>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    

</ul>