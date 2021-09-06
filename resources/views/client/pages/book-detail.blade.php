@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/book-detail.css') }}">
@endsection
@section('title', $book->title )

@section('content')



<div class="container">
    <div class="book-detail-content row">

        <div class="col-md-4 book-cover">
            <div class="book-cover__wrapper">
                <img src="{{ asset($book->image )}}" class="book-cover__image" alt="">
            </div>
        </div>

        <div class="col-md-8">
            <!-- @if (session('message'))
            <div class="alert alert-primary @if (session('alert')) {{ session('alert') }} @endif text-center">
                {{ session('message') }}
            </div>
            @endif -->
            <div class="book-detail-info">
                <div class="book-info__header">
                    <div class="book-info__title">
                        <h2>
                            {{ $book->title }}
                        </h2>
                    </div>
                    <div class="book-info__authors">

                        @foreach ($book->authors as $author)
                        @if ($loop->last)
                        <span class="info-authors__name"><a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a></span>
                        @else
                        <span class="info-authors__name"><a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a>, </span>
                        @endif
                        @endforeach
                    </div>
                    <div class="book-info-rating">
                        <div class="rate-stars">
                            @for ($i=1; $i <= 5; $i++) @if (round($avg_rating,1)>= round($i,1) )
                                <i class="fas fa-star"></i>
                                @else
                                <i class="far fa-star"></i>
                                @endif
                                @endfor

                        </div>
                        <span class="review-count ">( {{ round($avg_rating,1) }} / 5 )</span>
                    </div>

                </div>
                <div class="book-button-group">
                    @if ($ordered)
                    <div class="book-button-item">
                        <a href="{{ route('book.read', $book->slug) }}" class="button button__outline-lg button-custom">Đọc sách</a>
                        @if (count($book->bookAudios)>0)
                        <button type="button" class="button button__background-lg js-button-audio">Audio</button>
                        @endif
                    </div>
                    @else
                    <div class="book-button-item">
                        <a href="{{ route('Book.Order', ['id' => $book->id]) }}" class="button button__background-lg">Mượn sách</a>
                    </div>
                    <div class="book-button-item">
                        <a href="{{ route('book.review', $book->slug) }}" class="button button__outline-lg ">Xem
                            trước</a>
                    </div>
                    @endif
                </div>
                <div class="book-info__description">
                    <div class="book-description__wrapper">
                        <div class="book-description__text">
                            {!! $book->description !!}

                        </div>
                    </div>
                    <a href="javascript:void(0);" id="js-read-more" class="read-more ">Xem thêm </a>
                </div>

                <div class="book-info__tags">
                    @foreach ($book->categories as $cate)
                    <div class="info-tag__item">
                        <a href="{{ route('book.category', $cate->slug) }}" class="button button__outline-sm">{{ $cate->name }}</a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="js-modal-audio hidden">
        <div class="audio-modal__header">
            <div class="audio-modal-header__text">Tệp audio</div>
            <div class="audio-modal-header__close"><a href="javascript:void(0)" class="js-close-modal"><i class="fas fa-times"></i></a></div>
        </div>
        <div class="audio-modal__body">
            @if(count($book->bookAudios)>0)
            @foreach($book->bookAudios as $audio)
            <audio src="{{$audio->url}}" id="show_list_audio" controls>
                Trình duyệt không hỗ trợ phát âm thanh
            </audio>

            @endforeach
            @else
            Không có tệp audio nào
            @endif
        </div>
    </div>

    <div class="book-tabs data-tabs">
        <div class="book-tabs__wrapper">
            <ul class=" nav nav-tabs book-tabs__list">
                <li class="book-tabs__item">
                    <a class="book-tabs__link active" data-toggle="tab" href="#comment-tab">Bình luận</a>
                </li>
                <li class="book-tabs__item">
                    <a class="book-tabs__link" data-toggle="tab" href="#review-tab">Đánh giá </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="book-tabs__comment tab-pane in active" id="comment-tab">
                <!-- @include('client.blocks.commentsDisplay', ['comments' => $comments, 'book_id' => $book->id]) -->
                <div class="js-book-user-comment" id="js-book-user-comment"></div>
                <div class="comment-box__wrapper">
                    <div class="comment-box__image">
                        <img src="{{ asset(Auth::user()->avatar) }}" alt="" id="js-user-avatar">
                    </div>
                    <div class="comment-box__content">
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <div class="comment__input">
                                <textarea class="form-control" name="body" rows="2" placeholder="Viết bình luận..."></textarea>
                                <input type=hidden name=book_id value="{{ $book->id }}" />
                            </div>
                            <div class="comment__btn">
                                <button type="submit" class="button button__background-lg button-comment">Bình
                                    luận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="book-tabs__comment tab-pane" id="review-tab">
                <!-- @if(count($rates)> 0)
                @foreach ($rates as $rate)
                @if ($rate->user)
                <div class="book-user-comment " >
                    <div class="comment-box__image">
                        <img src="{{ $rate->user->avatar }}" alt="">
                    </div>
                    <div class="book-user-comment__body">
                        <div class="book-user-comment__heading">
                            <div class="book-user-comment__name">{{ $rate->user->name }}</div>
                            <div class="book-user-comment__footer">
                                <div class="book-user-comment__link">
                                    <span class="book-star">

                                        @for ($i = 1; $i <= 5; $i++) @if($i <=$rate->rating)
                                            <i class="fas fa-star "></i>
                                            @else
                                            <i class="far fa-star "></i>
                                            @endif
                                            @endfor
                                            <span>
                                </div>
                                <div class="book-user-comment__date">
                                    {{ date('d-m-Y', strtotime($rate->created_at)) }}
                                </div>
                            </div>
                            <div class="book-user-comment__content">
                                {{ $rate->body }}

                            </div>
                        </div>

                    </div>

                </div>
                @endif
                @endforeach
                @else
                <div class="book-user-comment__message">
                    Chưa có đánh giá nào
                </div>
                @endif -->
            </div>
        </div>
    </div>
    <!-- mobile -->
    <div class="book-carouse book-carouse-mobile">
        <div class="book-carouse__header">
            <div class="carouse-header__title">Sách cùng thể loại</div>
        </div>
        <div class="book-carouse__body">
            @if (count($sameBooksUnique) > 0)
            <div id="carouselExampleControls" class="carousel slide m-0 p-0" data-ride="carousel">

                <!-- Carouse Content -->
                <div class="carousel-inner">
                    <!-- Carouse Item -->
                    @if (count($sameBooksUnique) > 0)
                    <div class="carousel-item active">
                        <div class="book-carousel__wrapper">
                            @foreach ($sameBooksUnique as $book)
                            @if ($loop->index < 1) <div class="book-card ">
                                <div class="book-card__img">
                                    <a href="{{ route('book.detail', $book->slug) }}">
                                        <img src="{{ asset($book->image) }}" alt="" />
                                    </a>
                                </div>
                                <div class="book-card__title">
                                    <a href="{{ route('book.detail', $book->slug) }}">
                                        <h3> {{ $book->title }} </h3>
                                    </a>
                                </div>
                                <div class="book-card__author">
                                    @foreach ($book->authors as $author)
                                    @if ($loop->last)
                                    {{ $author->name }}
                                    @else
                                    {{ $author->name }},
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
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if (count($sameBooksUnique) > 2)
                <div class="carousel-item">
                    <div class="book-carousel__wrapper">

                        @foreach ($sameBooksUnique as $book)
                        @if ($loop->index >= 1 && $loop->index < 2) <div class="book-card ">
                            <div class="book-card__img">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <img src="{{ asset($book->image) }}" alt="" />
                                </a>
                            </div>
                            <div class="book-card__title">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <h3> {{ $book->title }} </h3>
                                </a>
                            </div>
                            <div class="book-card__author">
                                @foreach ($book->authors as $author)
                                @if ($loop->last)
                                {{ $author->name }}
                                @else
                                {{ $author->name }},
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
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @if (count($sameBooksUnique) > 2)
            <div class="carousel-item">
                <div class="book-carousel__wrapper">

                    @foreach ($sameBooksUnique as $book)
                    @if ($loop->index >= 2 && $loop->index < 3) <div class="book-card ">
                        <div class="book-card__img">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <img src="{{ asset($book->image) }}" alt="" />
                            </a>
                        </div>
                        <div class="book-card__title">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <h3> {{ $book->title }} </h3>
                            </a>
                        </div>
                        <div class="book-card__author">
                            @foreach ($book->authors as $author)
                            @if ($loop->last)
                            {{ $author->name }}
                            @else
                            {{ $author->name }},
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
                @endif
                @endforeach
            </div>
        </div>
        @endif
        @if (count($sameBooksUnique) > 2)
        <div class="carousel-item">
            <div class="book-carousel__wrapper">

                @foreach ($sameBooksUnique as $book)
                @if ($loop->index >= 3 && $loop->index < 4) <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{ route('book.detail', $book->slug) }}">
                            <img src="{{ asset($book->image) }}" alt="" />
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{ route('book.detail', $book->slug) }}">
                            <h3> {{ $book->title }} </h3>
                        </a>
                    </div>
                    <div class="book-card__author">
                        @foreach ($book->authors as $author)
                        @if ($loop->last)
                        {{ $author->name }}
                        @else
                        {{ $author->name }},
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
            @endif
            @endforeach
        </div>
    </div>
    @endif
</div>


@if (count($sameBooksUnique) > 2)

<a class="carousel-control-prev carousel-custom-prev " href="#carouselExampleControls" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next carousel-custom-next" href="#carouselExampleControls" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>

</a>
@endif
@else
<div class="book-user-comment__message">
    Chưa sách cùng thể loại
</div>
@endif
</div>
</div>

<!-- Button Carouse -->

</div>

<!-- table -->

<div class="book-carouse book-carouse-table">
    <div class="book-carouse__header">
        <div class="carouse-header__title">Sách cùng thể loại</div>
    </div>
    <div class="book-carouse__body">
        @if (count($sameBooksUnique) > 0)
        <div id="sameBookUniqueTable" class="carousel slide m-0 p-0" data-ride="carousel">

            <!-- Carouse Content -->
            <div class="carousel-inner">
                <!-- Carouse Item -->
                @if (count($sameBooksUnique) > 0)
                <div class="carousel-item active">
                    <div class="book-carousel__wrapper">
                        @foreach ($sameBooksUnique as $book)
                        @if ($loop->index < 2) <div class="book-card ">
                            <div class="book-card__img">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <img src="{{ asset($book->image) }}" alt="" />
                                </a>
                            </div>
                            <div class="book-card__title">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <h3> {{ $book->title }} </h3>
                                </a>
                            </div>
                            <div class="book-card__author">
                                @foreach ($book->authors as $author)
                                @if ($loop->last)
                                {{ $author->name }}
                                @else
                                {{ $author->name }},
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
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @if (count($sameBooksUnique) > 2)
            <div class="carousel-item">
                <div class="book-carousel__wrapper">

                    @foreach ($sameBooksUnique as $book)
                    @if ($loop->index >= 2 && $loop->index < 4) <div class="book-card ">
                        <div class="book-card__img">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <img src="{{ asset($book->image) }}" alt="" />
                            </a>
                        </div>
                        <div class="book-card__title">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <h3> {{ $book->title }} </h3>
                            </a>
                        </div>
                        <div class="book-card__author">
                            @foreach ($book->authors as $author)
                            @if ($loop->last)
                            {{ $author->name }}
                            @else
                            {{ $author->name }},
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
                @endif
                @endforeach
            </div>
        </div>
        @endif
        @if (count($sameBooksUnique) > 2)
        <div class="carousel-item">
            <div class="book-carousel__wrapper">

                @foreach ($sameBooksUnique as $book)
                @if ($loop->index >= 4 && $loop->index < 6) <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{ route('book.detail', $book->slug) }}">
                            <img src="{{ asset($book->image) }}" alt="" />
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{ route('book.detail', $book->slug) }}">
                            <h3> {{ $book->title }} </h3>
                        </a>
                    </div>
                    <div class="book-card__author">
                        @foreach ($book->authors as $author)
                        @if ($loop->last)
                        {{ $author->name }}
                        @else
                        {{ $author->name }},
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
            @endif
            @endforeach
        </div>
    </div>
    @endif
    @if (count($sameBooksUnique) > 2)
    <div class="carousel-item">
        <div class="book-carousel__wrapper">

            @foreach ($sameBooksUnique as $book)
            @if ($loop->index >= 6 && $loop->index < 8) <div class="book-card ">
                <div class="book-card__img">
                    <a href="{{ route('book.detail', $book->slug) }}">
                        <img src="{{ asset($book->image) }}" alt="" />
                    </a>
                </div>
                <div class="book-card__title">
                    <a href="{{ route('book.detail', $book->slug) }}">
                        <h3> {{ $book->title }} </h3>
                    </a>
                </div>
                <div class="book-card__author">
                    @foreach ($book->authors as $author)
                    @if ($loop->last)
                    {{ $author->name }}
                    @else
                    {{ $author->name }},
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
        @endif
        @endforeach
    </div>
</div>
@endif
</div>


@if (count($sameBooksUnique) > 2)

<a class="carousel-control-prev carousel-custom-prev " href="#sameBookUniqueTable" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next carousel-custom-next" href="#sameBookUniqueTable" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>

</a>
@endif
@else
<div class="book-user-comment__message">
    Chưa sách cùng thể loại
</div>
@endif
</div>
</div>

<!-- Button Carouse -->

</div>

<!-- desktop -->

<div class="book-carouse book-carouse-desktop">
    <div class="book-carouse__header">
        <div class="carouse-header__title">Sách cùng thể loại</div>
    </div>
    <div class="book-carouse__body">
        @if (count($sameBooksUnique) > 0)
        <div id="sameBookUniqueDesktop" class="carousel slide m-0 p-0" data-ride="carousel">

            <!-- Carouse Content -->
            <div class="carousel-inner">
                <!-- Carouse Item -->
                @if (count($sameBooksUnique) > 0)
                <div class="carousel-item active">
                    <div class="book-carousel__wrapper">
                        @foreach ($sameBooksUnique as $book)
                        @if ($loop->index < 4) <div class="book-card ">
                            <div class="book-card__img">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <img src="{{ asset($book->image) }}" alt="" />
                                </a>
                            </div>
                            <div class="book-card__title">
                                <a href="{{ route('book.detail', $book->slug) }}">
                                    <h3> {{ $book->title }} </h3>
                                </a>
                            </div>
                            <div class="book-card__author">
                                @foreach ($book->authors as $author)
                                @if ($loop->last)
                                {{ $author->name }}
                                @else
                                {{ $author->name }},
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
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
            @if (count($sameBooksUnique) > 4)
            <div class="carousel-item">
                <div class="book-carousel__wrapper">

                    @foreach ($sameBooksUnique as $book)
                    @if ($loop->index >= 4 && $loop->index < 8) <div class="book-card ">
                        <div class="book-card__img">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <img src="{{ asset($book->image) }}" alt="" />
                            </a>
                        </div>
                        <div class="book-card__title">
                            <a href="{{ route('book.detail', $book->slug) }}">
                                <h3> {{ $book->title }} </h3>
                            </a>
                        </div>
                        <div class="book-card__author">
                            @foreach ($book->authors as $author)
                            @if ($loop->last)
                            {{ $author->name }}
                            @else
                            {{ $author->name }},
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
                @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>


    @if (count($sameBooksUnique) > 4)

    <a class="carousel-control-prev carousel-custom-prev " href="#sameBookUniqueDesktop" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next carousel-custom-next" href="#sameBookUniqueDesktop" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>

    </a>
    @endif
    @else
    <div class="book-user-comment__message">
        Chưa sách cùng thể loại
    </div>
    @endif
</div>
</div>

<!-- Button Carouse -->

</div>

</div>




</div>
</div>
















@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('js\client\book-detail.js')}}"></script>
@endsection