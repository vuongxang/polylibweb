@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/search.css') }}">
@endsection
@section('title','PolyLib')
@section('content')


<div class="container">

    <div class="search-tab__container">
        <div class="search-tab__header">
            Hiển thị theo: 
        </div>
        <ul class="nav nav-pills search-tab__nav" id="pills-tab" role="tablist">
            <li class="nav-item search-tab__item">
                <a class="nav-link active search-tab__link" href="{{route('searchID','author',$keyword)}}"  id="js-show-by-book">Sách</a>
            </li>
            <li class="nav-item search-tab__item">
                <a class="nav-link search-tab__link"  id = "js-show-by-author"  href="{{route('searchID','author',$keyword)}}">Tác giả</a>
            </li>
            <li class="nav-item search-tab__item">
                <a class="nav-link search-tab__link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
            </li>
        </ul>

    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum earum debitis, iste consequatur at omnis, ea incidunt iure minus maxime temporibus deserunt fugit commodi obcaecati! Vel qui consectetur aliquid voluptate!</div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum earum debitis, iste consequatur at omnis, ea incidunt iure minus maxime temporibus deserunt fugit commodi obcaecati! Vel qui consectetur aliquid voluptate!</div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum earum debitis, iste consequatur at omnis, ea incidunt iure minus maxime temporibus deserunt fugit commodi obcaecati! Vel qui consectetur aliquid voluptate!</div>
    </div>
    <div class="row">
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <!-- <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link">
                            <li class="filter-item">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div> -->

                <div class=" filter-group ">
                    <h3 class="filter-heading">Danh mục</h3>
                    <form action="" id="filter-form">
                        <ul class="filter-list ">

                            @foreach($categories as $cate)
                            <li class="filter-item js-filter-item">
                                <div class="filter-item__checkbox">
                                    <input type="checkbox" name="cate[]" value="{{$cate->id}}" class="filter-item__input" id="check-box-{{$cate->id}}">
                                    <label>{{$cate->name}}</label>
                                </div>
                                <span class="filter-item__quantity">{{count($cate->books)}}</span>
                            </li>
                            @endforeach


                        </ul>
                    </form>
                </div>



            </div>
        </div>
        <div class="col-md-9 book-category__content">
            <div class="search-result">
                <div class="search-text" id="js-search-text">
                    Tìm thấy <span id="book-qty">{{count($books)}}</span> kết quả cho <span class="search-text-detail">"{{$keyword}}"</span>
                </div>
            </div>
            @if(isset($catee) )
            @foreach($catee as $cate)

            <div class="search-result">
                <div class="search-text">
                    Có <span class="search-text-detail">{{count($cate->books)}} </span>cuốn sách thuộc {{$cate->name}}
                </div>
            </div>
            @endforeach
            @endif
            <div class="book-card-collection" id="js-book-card-collection">
                @if(isset($catee) )
                @foreach($catee as $cate)
                @foreach($cate->books as $book)
                <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{route('book.detail',$book->id)}}">
                            <img src="{{$book->image}}" alt="">
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{route('book.detail',$book->id)}}">
                            <h3> {{$book->title}} </h3>
                        </a>
                    </div>
                    <div class="book-card__author">
                        @foreach($book->authors as $author)
                        @if($loop->last)
                        {{$author->name}}
                        @else
                        {{$author->name}},
                        @endif
                        @endforeach
                    </div>
                    <div class="book-card__star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="book-card__btn">
                        <a href="{{route('Book.Order',$book->id)}}" class="borrow-btn">Mượn sách</a><a href="{{route('book.read',$book->id)}}" class="review-btn">Xem trước</a>
                    </div>
                </div>
                @endforeach
                @endforeach
                @else
                @foreach($books as $book)
                <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{route('book.detail',$book->id)}}">
                            <img src="{{$book->image}}" alt="">
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{route('book.detail',$book->id)}}">
                            <h3> {{$book->title}} </h3>
                        </a>
                    </div>
                    <div class="book-card__author">
                        @foreach($book->authors as $author)
                        @if($loop->last)
                        {{$author->name}}
                        @else
                        {{$author->name}},
                        @endif
                        @endforeach
                    </div>
                    <div class="book-card__star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="book-card__btn">
                        <a href="{{route('Book.Order',$book->id)}}" class="borrow-btn">Mượn sách</a><a href="{{route('book.read',$book->id)}}" class="review-btn">Xem trước</a>
                    </div>
                </div>
                @endforeach

                @endif

            </div>


        </div>

    </div>
</div>


@endsection
@section('script')
<script src="{{asset('js\client\search.js')}}"></script>
@endsection