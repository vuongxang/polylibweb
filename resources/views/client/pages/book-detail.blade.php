@extends('client.layouts.index')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/book-detail.css') }}">
@endsection
@section('title', 'Trang Chi tiết')

@section('content')

    @if (session('thongbao'))
        {{-- <script>
    alert("{{ session('thongbao') }}")
</script> --}}
        <div class="alert @if (session('alert')) {{ session('alert') }} @endif text-center">
            <h1 class="@if (session('text-alert')) {{ session('text-alert') }} @endif" style="font-size: 20pt; font-weight:700">{{ session('thongbao') }}</h1>
        </div>
    @endif


    <div class="container">
        <div class="book-detail-content row">

            <div class="col-md-4 book-cover">
                <div class="book-cover__wrapper">
                    <img src="{{ $book->image }}" class="book-cover__image" alt="">
                </div>
            </div>

<<<<<<< HEAD
        <div class="col-md-8">
            <div class="book-detail-info">
                <div class="book-info__header">
                    <div class="book-info__title">
                        <h2>
                            {{ $book->title }}
                        </h2>
                    </div>
                    <div class="book-info__authors">
                        @foreach ($book->authors as $author)
                        <span class="info-authors__name"> {{ $author->name }}</span>
                        @endforeach
                    </div>
                    <div class="book-info-rating">
                        <div class="rate-stars">
                            @for ($i=1; $i <= 5; $i++) 
                                @if (round($avg_rating,1) >= round($i,1) )
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                                <!-- <i class="fas fa-star"></i> -->
                            @endfor
                            @if($avg_rating>0)
                                {{ round($avg_rating,1) }}
                            @endif
                        </div>
                        <span class="review-count ">( {{ count($rates) }} đánh giá )</span>
                    </div>
=======
            <div class="col-md-8">
                <div class="book-detail-info">
                    <div class="book-info__header">
                        <div class="book-info__title">
                            <h2>
                                {{ $book->title }}
                            </h2>
                        </div>
                        <div class="book-info__authors">
                            @foreach ($book->authors as $author)
                                <span class="info-authors__name"> {{ $author->name }}</span>
                            @endforeach
                        </div>
                        <div class="book-info-rating">
                            <div class="rate-stars">
                                @for ($i=1; $i <= 5; $i++) 
                                    @if (round($avg_rating,1) >= round($i,1) )
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                    <!-- <i class="fas fa-star"></i> -->
                                @endfor
                                @if($avg_rating>0)
                                    {{ round($avg_rating,1) }}
                                @endif
                            </div>
                            <span class="review-count ">( {{ count($rates) }} đánh giá )</span>
                        </div>
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1

                    </div>
                    <div class="book-button-group">
                        @if ($ordered)
                            <div class="book-button-item">
                                <a href="{{ route('book.read', $book->id) }}"
                                    class="button button__outline-lg button-custom">Đọc sách</a>
                            </div>
                        @else
                            <div class="book-button-item">
                                <a href="{{ route('Book.Order', ['id' => $book->id]) }}"
                                    class="button button__background-lg">Mượn sách</a>
                            </div>
                            <div class="book-button-item">
                                <a href="{{ route('book.read', ['id' => $book->id]) }}"
                                    class="button button__outline-lg ">Xem trước</a>
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
                                <a href="{{ route('book.category', $cate->slug) }}"
                                    class="button button__outline-sm">{{ $cate->name }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="book-tabs data-tabs">
            <div class="book-tabs__wrapper">
                <ul class=" nav nav-tabs book-tabs__list">
                    <li class="book-tabs__item">
                        <a class="book-tabs__link active" data-toggle="tab" href="#comment-tab">Bình luận</a>
                    </li>
                    <li class="book-tabs__item">
                        <a class="book-tabs__link" data-toggle="tab" href="#review-tab">Phản hồi ({{ count($rates) }}) </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="book-tabs__comment tab-pane in active" id="comment-tab">


                    @include('client.blocks.commentsDisplay', ['comments' => $book->comments, 'book_id' => $book->id])

<<<<<<< HEAD
    <div class="book-tabs data-tabs">
        <div class="book-tabs__wrapper">
            <ul class=" nav nav-tabs book-tabs__list">
                <li class="book-tabs__item">
                    <a class="book-tabs__link active" data-toggle="tab" href="#comment-tab">Bình luận</a>
                </li>
                <li class="book-tabs__item">
                    <a class="book-tabs__link" data-toggle="tab" href="#review-tab">Đánh giá/Phản hồi ({{count($rates)}}) </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="book-tabs__comment tab-pane in active" id="comment-tab">
=======
                    <div class="comment-box__wrapper">
                        <div class="comment-box__image">
                            <img src="{{ Auth::user()->avatar }}" alt="">
                        </div>
                        <div class="comment-box__content">
                            <form action="{{ route('comments.store') }}" method="post">
                                @csrf
                                <div class="comment__input">
                                    <textarea class="form-control" name="body" rows="2"
                                        placeholder="Viết bình luận..."></textarea>
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
                    @foreach ($rates as $rate)
                        @if ($rate->user)
                            <div class="book-user-comment">
                                <div class="comment-box__image">
                                    <img src="{{ $rate->user->avatar }}" alt="">
                                </div>
                                <div class="book-user-comment__body">
                                    <div class="book-user-comment__heading">
                                        <div class="book-user-comment__name">{{ $rate->user->name }}</div>
                                        <div class="book-user-comment__footer">
                                            <div class="book-user-comment__link"><span class="book-star">
                                                    @for ($i = 0; $i < $rate->rating; $i++)
                                                        <i class="fas fa-star "></i>
                                                    @endfor
                                                    <span>
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1

                                            </div>
                                            <div class="book-user-comment__date">
                                                {{ date('d-m-Y', strtotime($rate->created_at)) }}</div>
                                        </div>
                                        <div class="book-user-comment__content">
                                            {{ $rate->body }}

                                        </div>
                                    </div>

                                </div>
                            </div>
>>>>>>> main

                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 

        <div class="book-carouse">
            <div class="book-carouse__header">
                <div class="carouse-header__title">Sách cùng thể loại</div>
            </div>
            <div class="book-carouse__body">

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                    <div class="carousel-inner">
                        @if (count($sameBooksUnique) > 0)
                        <div class="carousel-item active">
                            <div class="row">

                                @foreach ($sameBooksUnique as $book)
                                @if ($loop->index < 4) <div class="col-3">
                                    <div class="book-card ">
                                        <div class="book-card__img">
                                            <a href="{{ route('book.detail', $book->id) }}">
                                                <img src="{{ $book->image }}" alt="">
                                            </a>
                                        </div>
                                        <div class="book-card__title">
                                            <a href="{{ route('book.detail', $book->id) }}">
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
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="book-card__btn">
                                            <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a><a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                        </div>
                                    </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
<<<<<<< HEAD
                    <div class="book-comment-body-detail__content">
                        <div class="book-comment-body-detail__username">
                            {{ $rate->user->name }}
                            <p style="color:#bdbdbd; font-size:10pt">
                                {{ $rate->created_at->toDateString() }}
                            </p>

                        </div>
                        <div class="book-comment-body-detail__date">
                            <span class="book-star">
                                @for ($i = 1; $i <= 5; $i++)
                                    <!-- <i class="fas fa-star text-"></i> -->
                                    @if ($rate->rating >= $i )
                                    <i class="fas fa-star"></i>
                                    @else
                                    <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            <span>
=======
                    @if (count($sameBooksUnique) > 4)
                    <div class="carousel-item">
                        <div class="row">
                            @foreach ($sameBooksUnique as $book)
                            @if ($loop->index >= 4 && $loop->index < 8) <div class="col-3">
                                <div class="book-card ">
                                    <div class="book-card__img">
                                        <a href="{{ route('book.detail', $book->id) }}">
                                            <img src="{{ $book->image }}" alt="">
                                        </a>
                                    </div>
                                    <div class="book-card__title">
                                        <a href="{{ route('book.detail', $book->id) }}">
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
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div class="book-card__btn">
                                        <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a><a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                    </div>
                                </div>
>>>>>>> 1223927534c04bcf6f7bfe2b23a8e1a6953af6a1
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                @if (count($sameBooksUnique) > 4)

                <a class="carousel-control-prev carousel-custom-prev " href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next carousel-custom-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    
                </a>
                @endif
            </div>


        </div> -->

        <div class="book-carouse">
            <div class="book-carouse__header">
                <div class="carouse-header__title">Sách cùng thể loại</div>
            </div>
            <div class="book-carouse__body">

                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                    <!-- Carouse Content -->
                    <div class="carousel-inner">
                        <!-- Carouse Item -->
                        @if (count($sameBooksUnique) > 0)
                            <div class="carousel-item active">
                                <div class="book-carousel__wrapper">

                                    @foreach ($sameBooksUnique as $book)

                                        @if ($loop->index < 4)
                                            <div class="book-card ">
                                                <div class="book-card__img">
                                                    <a href="{{ route('book.detail', $book->id) }}">
                                                        <img src="{{ $book->image }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="book-card__title">
                                                    <a href="{{ route('book.detail', $book->id) }}">
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
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="book-card__btn">
                                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn
                                                        sách</a><a href="{{ route('book.read', $book->id) }}"
                                                        class="review-btn">Xem trước</a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                        @endif
                    </div>
                    @if (count($sameBooksUnique) > 4)
                        <div class="carousel-item">
                            <div class="row">

                                @foreach ($sameBooksUnique as $book)
                                    @if ($loop->index >= 4 && $loop->index < 8)
                                        <div class="col-3">
                                            <div class="book-card ">
                                                <div class="book-card__img">
                                                    <a href="{{ route('book.detail', $book->id) }}">
                                                        <img src="{{ $book->image }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="book-card__title">
                                                    <a href="{{ route('book.detail', $book->id) }}">
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
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </div>
                                                <div class="book-card__btn">
                                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn
                                                        sách</a><a href="{{ route('book.read', $book->id) }}"
                                                        class="review-btn">Xem trước</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                    @endif
                </div>
                @if (count($sameBooksUnique) > 4)

                    <a class="carousel-control-prev carousel-custom-prev " href="#carouselExampleControls" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next carousel-custom-next" href="#carouselExampleControls" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>

                    </a>
                @endif
            </div>

            <!-- Button Carouse -->

        </div>
    </div>
    </div>


    </div>





















    <script>
        let readMore = document.querySelector('#js-read-more');
        let desc = document.querySelector('.book-description__text');
        console.log(desc.offsetHeight);
        if (desc.offsetHeight < 240) {
            desc.parentNode.style.height = "auto";
            readMore.style.display = "none";
        }

        readMore.addEventListener('click', () => {
            let x = readMore.parentElement.querySelector('.book-description__wrapper')
            x.classList.toggle("show-more");
            (x.classList.contains('show-more')) ? readMore.innerHTML = "Ẩn bớt ": readMore.innerHTML = "Xem thêm ";
        })




        let replyParentElement = document.querySelectorAll('.js-comment-reply');
        let btnCancelElement = document.querySelectorAll('.button-cancel');
        let commentWrapperElement = document.querySelectorAll('.comment-box__wrapper');
        let replyChildElement = document.querySelectorAll('.js-comment-reply-child');
        replyParentElement.forEach((item) => {
            item.addEventListener('click', () => {
                item.closest('.js-comment-body').querySelector('.comment-box__wrapper').classList.remove(
                    'comment-box__hidden');
                item.closest('.js-comment-body').querySelector('input[name="body"]').focus();
            })
        })
        // turn off comment box
        btnCancelElement.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                commentWrapperElement[index].classList.add('comment-box__hidden');
                commentWrapperElement[index].querySelector('form').reset();

            })
        })
        // Chọn trả lời thằng con 
        replyChildElement.forEach((item, index) => {
            console.log(item, index);
            item.addEventListener('click', () => {
                const a = item.closest('.js-comment-body').querySelector('.comment-box__wrapper');
                a.classList.remove('comment-box__hidden');
                a.querySelector('input[name="body"]').focus();
                // console.log(item.parentElement.parentElement.parentElement.parentElement.parentElement.querySelector('.comment-box__wrapper').classList.remove('comment-box__hidden'))
            })
        })
    </script>


@endsection
