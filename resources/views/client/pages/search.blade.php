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
                <a class="search-tab__link" data-toggle="tab" href="#books">Sách</a>
            </li>
            <li class="nav-item search-tab__item">
                <a class="search-tab__link active" data-toggle="tab" href="#authors">Tác giả</a>
            </li>
            <!-- <li class="nav-item search-tab__item">
                <a class="nav-link search-tab__link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
            </li> -->
        </ul>

    </div>
    <div class="tab-content">
        <div class="tab-pane in " id="books">
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

        </div>
        <div class="tab-pane  active" id="authors">
            <div class="search-container">
                <div class="search-result">
                    <div class="search-text" id="js-search-text">
                        Tìm thấy <span id="book-qty">{{count($books)}}</span> kết quả cho <span class="search-text-detail">"{{$keyword}}"</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 search-author__aside">
                        <div class="search-author-wrapper">
                            <div class="author-avatar ">
                                <a href="">
                                    <img src="https://cdn.dribbble.com/users/1418633/avatars/normal/1f3114a05eee34cc04e80e80daef10e0.jpg?1483969865" alt="">
                                </a>
                            </div>
                            <div class="author-info">
                                <div class="author-info__name">
                                    <a href="">
                                        Rahul Khobragade
                                    </a>
                                </div>
                                <div class="author-info__description">
                                    Passionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of workingPassionate graphic designer and illustrator with a demonstrated history of working in the Product Design and video pr...
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 search-author__container">
                        <div class="author-books">
                            <div class="author-books__list">
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://m.media-amazon.com/images/I/91tehktTqyL._AC_US218_..jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://www.imgacademy.com/themes/custom/imgacademy/images/helpbox-contact.jpg" alt="">
                                    </a>
                                </div>
                                <div class="author-books__item">
                                    <a href="" class="author-books__link">
                                        <img class="author-books__img" src="https://res.cloudinary.com/bookbub/image/upload/t_ci_ar_6:9_scaled,f_auto,q_auto,dpr_1,c_scale,w_170/v1611670738/pro_pbid_1036135.jpg" alt="">
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



</div>


@endsection
@section('script')
<script src="{{asset('js\client\search.js')}}"></script>
@endsection