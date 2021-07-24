@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/home.css')}}">
<link rel="stylesheet" href="{{asset('css/client/pages/cate.css')}}">
@endsection
@section('title','Danh mục')
@section('content')

<main>
    <div class="search">
        <div class="search-text">
            <input type="text" placeholder="Tìm kiếm">
            <div><a href="#">Tất cả</a></div>
            <div><a href="#">Tác giả</a></div>
            <div><a href="#">Tiêu đề sách</a></div>
        </div>
        <div class="search-icon">
            <i class="fas fa-search"></i>
        </div>

    </div>
    <div class="filter">
        <div class="nav">
            <div class="menu-link">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Tác giả</a>
                    <div class="dropdown-menu">
                        @foreach($aut as $author)

                        <a class="dropdown-item" href="#">{{$author->name}}</a>
                        @endforeach
                    </div>
                </li>
            </div>
            <div class="menu-link">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Danh mục</a>
                    <div class="dropdown-menu">
                        @foreach($cate as $cates)

                        <a class="dropdown-item" href="#">{{$cates->name}}</a>
                        @endforeach
                    </div>
                </li>
            </div>
            <div class="menu-link">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Ngôn ngữ</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </div>
            <div class="menu-link">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Sắp xếp</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </div>
        </div>
    </div>
    <div class="product-slider">
        <div class="container">

            <div class="row">
                @foreach($book as $ct)
                <div class="box">
                    <a href="#">
                        <div class="box-image">
                            <img src="{{$ct['image']}}">

                        </div>
                    </a>
                    <a href="{{route('book.detail',$ct->id)}}">
                        <p class="box-title">{{$ct['title']}}</p>
                    </a>
                    <!-- @foreach($aut as $author)
                    <h4 class="box-authors">{{$author->name}}</h4>
                    @endforeach -->
                    <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                </div>
                @endforeach
            </div>
        </div>




    </div>
    <div class="center">
        <div class="slider">
            {!!$book->links('vendor.pagination.bootstrap-4')!!}
        </div>
    </div>





</main>
@endsection