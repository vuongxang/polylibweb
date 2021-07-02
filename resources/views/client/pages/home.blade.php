@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/home.css')}}">
@endsection
@section('title','Trang Chủ')
@section('content')

<main>
    <div class="banner">
        <div class="banner-content">
            <div class="banner-content__heading">
                <h2><span>Sách</span></h2>
                <h2> Bạn muốn đọc là gì?</h2>
            </div>
            <p class="banner-content__body">Tìm kiếm ngay thôi nào</p>
            <div class="banner-content__search">
                <form action="" class="search-form">
                    <input class="search-input" type="text" placeholder="Tìm kiếm theo tên sách, danh mục, tác giả">
                    <button class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="banner-image">
            <img src="{{asset('images/banner.svg')}}" alt="">
        </div>
    </div>


    <div class="book-list book__list--nobackground">
        <div class="book-list__heading space__between">
            <h2>Sách kinh điển</h2>
            <a href="">Xem thêm</a>
        </div>
        <div class="book-list__body space__between">


            <div class="book-item">
                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                <p> <span class="book-author"> Dan Brown </span></p>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                <p> <span class="book-author"> Dan Brown </span></p>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                <p> <span class="book-author"> Dan Brown </span></p>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                <h3>Nguồn Cội (Robert Langdon #5)</h3>
                <p> <span class="book-author"> Dan Brown </span></p>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>

        </div>

    </div>


    <div class="book-list book__list--background">
        <div class="book-list__heading space__between">
            <h2>Sách được đọc nhiều nhất</h2>
            <a href="">Xem thêm</a>
        </div>
        <div class="book-list__body space__between">

            <div class="book-item">
                <a href="">
                    <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                    <h3>Nguồn Cội (Robert Langdon #5)</h3>
                </a>
                <a href="">
                    <p> <span class="book-author"> Dan Brown </span></p>
                </a>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <a href="">
                    <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                    <h3>Nguồn Cội (Robert Langdon #5)</h3>
                </a>
                <a href="">
                    <p> <span class="book-author"> Dan Brown </span></p>
                </a>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <a href="">
                    <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                    <h3>Nguồn Cội (Robert Langdon #5)</h3>
                </a>
                <a href="">
                    <p> <span class="book-author"> Dan Brown </span></p>
                </a>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>
            <div class="book-item">
                <a href="">
                    <img src="{{asset('images/nguon-coi-dan-brown.png')}}" alt="">
                    <h3>Nguồn Cội (Robert Langdon #5)</h3>
                </a>
                <a href="">
                    <p> <span class="book-author"> Dan Brown </span></p>
                </a>
                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
            </div>

        </div>

    </div>
</main>
@endsection