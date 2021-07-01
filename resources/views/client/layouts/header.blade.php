<header class="header">
    <div class="header__logo">
        <img src="{{ asset('images/logo.png') }}" alt="" class="header__logo-img">
    </div>
    <ul class="header__nav">
        <li class="header__nav-li"><a class="link" href="">Trang Chủ</a></li>
        <li class="header__nav-li"><a class="link" href="">Danh Mục</a></li>
        <li class="header__nav-li"><a class="link" href="">Tin Tức</a></li>
    </ul>
    <div class="header__search">
        <form action="" class="header__search-form">
            <input class="header__search-input" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
            <button class="header__search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="header__information">
        <div class="header__information-notification">
            <img src="{{asset('images/notification.svg')}}" alt="">
        </div>
        <div class="header__information-info">
            <img src="{{asset('images/avatar.png')}}" alt="">
            <i class="fas fa-caret-down"></i>
        </div>
    </div>
</header>