@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/home.css')}}">
<link rel="stylesheet" href="{{asset('css/cate.css')}}">
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
            <div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Tác giả</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </div>
            <div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Danh mục</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </div>
            <div>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Ngôn ngữ</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Link 1</a>
                        <a class="dropdown-item" href="#">Link 2</a>
                        <a class="dropdown-item" href="#">Link 3</a>
                    </div>
                </li>
            </div>
            <div>
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
    <div class="product-slider row">
       
        <!-- <div class="col-sm-4">
            
                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                <p> <span class="book-author"> Dan Brown </span></p>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
        </div> -->
        @foreach($cate as $ct)
        <div class="col-sm-4">
        <h3>{{$ct['title']}}</h3>
              
        </div>
         @endforeach
         <div class=" justify-content-center">{!!$cate->links('vendor.pagination.bootstrap-4')!!}</div>
      
      
    </div>



</main>
@endsection