@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/category.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link">
                            <li class="filter-item">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class=" filter-group ">
                    <h3 class="filter-heading">Danh mục</h3>
                    <ul class="filter-list ">

                        @foreach($categories as $category)
                        <a href="{{route('book.category',$category->slug)}}" class="filter-item__link">
                            <li class="filter-item">
                                {{$category->name}}
                                <span class="filter-item__quantity">{{count($category->books)}}</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 book-category__content">
            @if(isset($catee) )
            @foreach($catee as $cate)
            
            <div class="search-result">
                <div class="search-text">
                    Có <span class="search-text-detail">{{count($cate->books)}} </span>cuốn sách thuộc {{$cate->name}}
                </div>
            </div>
            @endforeach
            @endif
            <div class="book-card-collection">
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



@endsection