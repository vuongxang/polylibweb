@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/search.css') }}">
@endsection
@section('title','PolyLib')
@section('content')


<div class="grid-custom">
    <div class="search-tab__container">
        <div class="search-tab__header">
            Hiển thị theo:
        </div>
        <ul class="nav nav-tabs search-tab__nav">
            <li class="nav-item search-tab__item">
                <a class="search-tab__link active" data-toggle="tab" href="#books">Sách</a>
            </li>
            <li class="nav-item search-tab__item">
                <a class="search-tab__link " data-toggle="tab" href="#authors">Tác giả</a>
            </li>
            <li class="nav-item search-tab__item">
                <a class=" search-tab__link" data-toggle="tab" href="#posts">Bài viết</a>
            </li>
        </ul>

    </div>
    <div class="tab-content">
        <div class="tab-pane in active" id="books">
            <div class="search-container">

                <div class="row">
                    <div class="col-md-3 book-category__aside">
                        <div class="book-search__aside ">

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
                                    <a href="{{route('book.detail',$book->slug)}}">
                                        <img src="{{$book->image}}" alt="">
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
                                    @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                    <a href="{{ route('book.read', $book->slug) }}" class="review-btn">Đọc sách</a>
                                    @else
                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                    <a href="{{ route('book.review', $book->slug) }}" class="review-btn">Xem trước</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endforeach
                            @else
                            @foreach($books as $book)
                            <div class="book-card ">
                                <div class="book-card__img">
                                    <a href="{{route('book.detail',$book->slug)}}">
                                        <img src="{{$book->image}}" alt="">
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
                                    @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                    <a href="{{ route('book.read', $book->slug) }}" class="review-btn">Đọc sách</a>
                                    @else
                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                    <a href="{{ route('book.review', $book->slug) }}" class="review-btn">Xem trước</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                            @endif

                        </div>


                    </div>

                </div>
            </div>

        </div>
        <div class="tab-pane " id="authors">
            <div class="search-container">
                <div class="search-result">
                    <div class="search-text" id="js-search-text">
                        Tìm thấy <span id="book-qty">{{count($authors)}}</span> kết quả cho <span class="search-text-detail">"{{$keyword}}"</span>
                    </div>
                </div>
                @foreach($authors as $author)
                <div class="row">
                    <div class="col-md-3 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="{{route('author.detail',$author->id)}}">
                                    <img src="{{$author->avatar}}" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="{{route('author.detail',$author->id)}}">
                                        {{$author->name}}
                                    </a>
                                </div>
                                <div class="author-info__dob">
                                    {{date('d-m-Y', strtotime($author->date_birth)) }}
                                </div>
                                <div class="author-info__description">
                                    {!! $author->description !!}
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-9 search-author__container">
                        <div class="author-books ">
                            <div class="author-books__list ">

                                @foreach($author->books as $book)
                                <div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="{{route('book.detail',$book->slug)}}">
                                            <img src="{{$book->image}}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="{{route('book.detail',$book->slug)}}">
                                            <h3> {{$book->title}}{{$loop->iteration}}</h3>
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
                                        @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                        <a href="{{ route('book.read', $book->slug) }}" class="review-btn">Đọc sách</a>
                                        @else
                                        <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                        <a href="{{ route('book.review', $book->slug) }}" class="review-btn">Xem trước</a>
                                        @endif
                                    </div>
                                </div>
                                @endforeach


                            </div>
                        </div>

                        <div class="slide-nav">

                            <button class="slide-nav__prev">

                                <i class="fas fa-chevron-left"> </i>
                            </button>
                            <button class="slide-nav__next">
                                <i class="fas fa-chevron-right"></i>
                            </button>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
        <div class="tab-pane   " id="posts">
            <div class="search-container">
                <div class="search-result">
                    <div class="search-text" id="js-search-text">
                        Tìm thấy <span id="book-qty">{{count($posts)}}</span> kết quả cho <span class="search-text-detail">"{{$keyword}}"</span>
                    </div>
                </div>
                <div class="post-list">
                    @foreach($posts as $post)
                    <div class="post-item">
                        <div class="post-card ">
                            <a class="post-card-link" href="{{ route('post.detail', $post->slug) }}">
                                <img src="{{asset($post->thumbnail)}}" class="post-card-img-top" alt="{{$post->slug}}">
                            </a>
                            <div class="post-card-body">
                                <div class="post-item__content">

                                    <div class="post-card-title">
                                        <a class="post-card-link" href="{{ route('post.detail', $post->slug) }}">
                                            {{ $post->title }}
                                        </a>
                                    </div>
                                    <div class="post-body__user">
                                        <div class="post-body-user__avatar">
                                            <a href="{{ route('post.user', $post->user()->withTrashed()->first()->id )}}">

                                                <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" alt="{{ asset($post->user()->withTrashed()->first()->avatar) }}">
                                            </a>
                                        </div>

                                        <div class="post-body-user__name">
                                            <a href="{{ route('post.user', $post->user()->withTrashed()->first()->id )}}" class="post-body-user__link">
                                                {{ $post->user()->withTrashed()->first()->name }}
                                            </a>
                                            <div class="post-body-created">
                                                29 thg 8
                                            </div>
                                        </div>

                                    </div>



                                    <div class="post-content__tag">
                                        @foreach($post->cates as $cate)
                                        <div class="post-tag__item">
                                            <a href="{{ route('post.category', $cate->slug) }}" class="post-tag__link">
                                                #{{$cate->name}}
                                            </a>
                                        </div>
                                        @endforeach

                                    </div>
                                    <div class="post-content__footer">
                                        <div class="post-footer__details">


                                            <div class="post-wishlist">
                                                <span class="post-wishlist__span">

                                                    <i class="fas fa-heart"></i>
                                                    Yêu thích
                                                </span>
                                            </div>

                                            <div class="post-comment">
                                                <span class="post-comment__span"><i class=" fa fa-comments"></i>
                                                    9 bình luận
                                                </span>
                                            </div>
                                            <div class="post-view">
                                                <span class="post-view__span"><i class=" fa fa-eye"></i>
                                                    9 lượt xem
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>

            </div>

        </div>
    </div>



</div>


@endsection
@section('script')
<script src="{{asset('js\client\search.js')}}"></script>
@endsection