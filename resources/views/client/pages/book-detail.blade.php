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
<div class="alert alert-success text-center">
    <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('thongbao') }}</h1>
</div>
@endif

<div>
    <div class="book-detail-content row">

        <div class="col-md-4 book-cover">
            <div class="book-cover__wrapper">
                <img src="{{ asset($book->image) }}" class="book-cover__image" alt="">
            </div>
        </div>

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
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            @for ($i=0; $i < floor($avg_rating); $i++) <i class="fas fa-star"></i>
                                @endfor
                        </div>
                        <span class="review-count ">( 352 )</span>
                    </div>

                </div>
                <div class="book-button-group">

                    @if ($ordered)
                    <div class="book-button-item">
                        <a href="{{ route('book.read', $book->id) }}" class="button button__outline-lg button-custom">Đọc sách</a>
                    </div>
                    @else
                    <div class="book-button-item">
                        <a href="{{ route('Book.Order', ['id' => $book->id]) }}" class="button button__background-lg">Mượn sách</a>
                    </div>
                    <div class="book-button-item">
                        <a href="{{ route('book.read', ['id' => $book->id]) }}" class="button button__outline-lg ">Xem trước</a>
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
                        <a href="{{route('book.category',$cate->slug)}}" class="button button__outline-sm">{{ $cate->name }}</a>
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
                    <a class="book-tabs__link" data-toggle="tab" href="#review-tab">Phản hồi ({{count($rates)}}) </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="book-tabs__comment tab-pane in active" id="comment-tab">


                @include('client.blocks.commentsDisplay', ['comments' => $book->comments, 'book_id' => $book->id])

                <div class="comment-box__wrapper">
                    <div class="comment-box__image">
                        <img src="{{Auth::user()->avatar}}" alt="">
                    </div>
                    <div class="comment-box__content">
                        <form action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <div class="comment__input">
                                <textarea class="form-control" name="body" rows="2" placeholder="What are you thinking?"></textarea>
                                <input type=hidden name=book_id value="{{ $book->id }}" />
                            </div>
                            <div class="comment__btn">
                                <button type="submit" class="button button__background-lg button-comment">Bình luận</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="book-comment__body tab-pane" id="review-tab">
                @foreach ($rates as $rate)
                <div class="book-comment-body__detail">
                    <div class="book-comment-body-detail__img">
                        <img src="{{ asset($rate->user->avatar) }}" alt="" class="rounded-circle" width="40">
                    </div>
                    <div class="book-comment-body-detail__content">
                        <div class="book-comment-body-detail__username">{{ $rate->user->name }}</div>
                        <div class="book-comment-body-detail__date">
                            <span class="book-star">
                                @for ($i = 0; $i < $rate->rating; $i++)
                                    <i class="fas fa-star text-"></i>
                                    @endfor
                                    <span>
                        </div>
                        <div class="book-comment-body-detail__comment">{{ $rate->body }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="book-list book__list--background">
        <div class="book-list__heading space__between">
            <h2>Sách cùng thể loại</h2>
            <a href="">Xem thêm</a>
        </div>
        <div id="carouselBookCate-background" class="carousel slide" data-ride="carousel" data-pause="hover">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <div class="row">
                        @foreach ($book->categories as $cate)
                        @foreach ($cate->books as $b)
                        @if ($b->id != $book->id)
                        @if ($loop->index <= 4) <div class="col-3">
                            <div class="book-item">
                                <a href="{{ route('book.detail', $b->id) }}">
                                    <img src="{{ asset($b->image) }}" alt="">
                                </a>
                                <a href="{{ route('book.detail', $b->id) }}">
                                    <h3>{{ $b->title }}</h3>
                                </a>

                                <p>
                                    <span class="book-star">
                                        @for ($i = 0; $i < floor($b->userAverageRating); $i++)
                                            <i class="fas fa-star"></i>
                                            @endfor
                                    </span>
                                </p>
                            </div>
                    </div>
                    @endif
                    @endif
                    @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </main>
    <script>
        let readMore = document.querySelector('#js-read-more');
        let desc = document.querySelector('.book-description__text');
        console.log(desc.offsetHeight);
        if(desc.offsetHeight < 240){
            desc.parentNode.style.height = "auto";
            readMore.style.display = "none";
        }

        readMore.addEventListener('click', () => {
            let x = readMore.parentElement.querySelector('.book-description__wrapper')
            x.classList.toggle("show-more");
            (x.classList.contains('show-more')) ? readMore.innerHTML = "Ẩn bớt ": readMore.innerHTML = "Xem thêm ";
        })
    </script>
    @endsection