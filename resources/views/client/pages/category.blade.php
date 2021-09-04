@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/category.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <!-- table -->
    <div class="row  cate-table">
        <div class="menu-table">
            <ul class="nav nav-pills">
                    <a href="{{route('book.categories')}}" class="filter-item__link ">
                        <li class="nav-item filter-item {{ Request::is('category') ? 'active' : null }}">
                            {{__('Tất cả')}}
                        </li>
                    </a>
                <li class="nav-item show-cate">
                    <a class="nav-link" href="#">Danh mục</a>
                </li>
            </ul>
            <div class="book-category__aside">
                <div class="book-search__aside ">
                    <div class=" filter-group ">
                        <ul class="filter-list ">
                            @foreach($categories as $category)
                            <a href="{{route('book.category',$category->slug)}}" class="filter-item__link  ">
                                <li class="filter-item {{ Request::is('category/'.$category->slug) ? 'active' : null }}">
                                    {{$category->name}}
                                    <span class="filter-item__quantity">{{$category->books_count}}</span>
                                </li>
                            </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="book-category__content">
            @if(!empty($message))
            <div class="search-result">
                <div class="search-text">
                    {{ $message }}
                </div>
            </div>
            @endif

            <div class="book-card-collection">
                @if(isset($books) )

                @foreach($books as $book)
                <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{route('book.detail',$book->slug)}}">
                            <img src="{{asset($book->image)}}" alt="">
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{route('book.detail',$book->slug)}}">
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
                        @for ($i=1; $i <= 5; $i++) @if (round(DB::table('ratings')->where('rateable_id', $book->id)->avg('rating'),1)>= round($i,1) )
                            <i class="fas fa-star"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                            @endfor


                    </div>
                    <div class="book-card__btn">
                        @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)
                        ->where('status', 'Đang mượn')->first() )
                        <a href="{{ route('book.read', $book->id) }}" class="review-btn">Đọc sách</a>
                        @else
                        <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn
                            sách</a><a href="{{ route('book.review', $book->slug) }}" class="review-btn">Xem
                            trước</a>
                        @endif
                    </div>
                </div>
                @endforeach



                @endif

            </div>
            @if(isset($books) )
            {{ $books->links('vendor.pagination.category-pagination') }}
            @endif
        </div>   
    </div>
    <!-- end table -->
    <div class="row cate-desktop">
        <div class="col-md-3 book-category__aside ">
            <div class="book-search__aside ">

                <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link ">
                            <li class="filter-item {{ Request::is('category') ? 'active' : null }}">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class=" filter-group ">
                    <h3 class="filter-heading">Danh mục</h3>
                    <ul class="filter-list ">

                        @foreach($categories as $category)
                        <a href="{{route('book.category',$category->slug)}}" class="filter-item__link  ">
                            <li class="filter-item {{ Request::is('category/'.$category->slug) ? 'active' : null }}">
                                {{$category->name}}
                                <span class="filter-item__quantity">{{$category->books_count}}</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 book-category__content ">
            @if(!empty($message))
            <div class="search-result">
                <div class="search-text">
                    {{ $message }}
                </div>
            </div>
            @endif

            <div class="book-card-collection">
                @if(isset($books) )

                @foreach($books as $book)
                <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{route('book.detail',$book->slug)}}">
                            <img src="{{asset($book->image)}}" alt="">
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{route('book.detail',$book->slug)}}">
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
                        @for ($i=1; $i <= 5; $i++) @if (round(DB::table('ratings')->where('rateable_id', $book->id)->avg('rating'),1)>= round($i,1) )
                            <i class="fas fa-star"></i>
                            @else
                            <i class="far fa-star"></i>
                            @endif
                            @endfor


                    </div>
                    <div class="book-card__btn">
                        @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)
                        ->where('status', 'Đang mượn')->first() )
                        <a href="{{ route('book.read', $book->slug) }}" class="review-btn">Đọc sách</a>
                        @else
                        <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn
                            sách</a><a href="{{ route('book.review', $book->slug) }}" class="review-btn">Xem
                            trước</a>
                        @endif
                    </div>
                </div>
                @endforeach



                @endif

            </div>
            @if(isset($books) )
            {{ $books->links('vendor.pagination.category-pagination') }}
            @endif
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.show-cate').click(function(){
          $('.book-category__aside').slideToggle();
        })
    })
</script>


@endsection