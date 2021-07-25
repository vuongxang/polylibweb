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

    <main>
        <div class="book-detail">
            <div class="book-detail__image">
                <img src="{{ asset($book->image) }}" alt="">
            </div>
            <div class="book-detail__content">
                <div class="book-detail-content__header">
                    <h2>
                        {{ $book->title }}
                    </h2>
                    <p>Tác giả:
                        @foreach ($book->authors as $author)
                            <span class="book-detail-content__header-author"> {{ $author->name }} </span>
                        @endforeach
                    </p>
                    <p>
                        Đánh giá:<span class="book-detail-content__header-star">
                            @for ($i = 0; $i < floor($book->userAverageRating); $i++)
                                <i class="fas fa-star"></i>
                            @endfor
                        </span>
                    </p>
                </div>
                <div class="book-detail-content__button">
                    {{-- @if (DB::table('orders')->where('book_id', $book->id)->exists() &&
                        DB::table('orders')->where('status', '==','Đang mượn'))
                        <a href="{{ route('book.read', $book->id) }}" class="btn btn-success">Đọc sách</a>
                    @elseif(DB::table('orders')->where('book_id', $book->id)->doesntExist() ||
                        DB::table('orders')->where('status','Đã trả')) --}}
                    @if ($ordered)
                        <a href="{{ route('book.read', $book->id) }}" class="btn btn-success">Đọc sách</a>
                    @else
                        <a href="{{ route('Book.Order', ['id' => $book->id]) }}" class="borrow-btn">Mượn sách</a>
                        <a href="{{ route('book.read', ['id' => $book->id]) }}" class="review-btn">Xem trước</a>
                    @endif
                </div>
                <div class="book-detail-content__desc">
                    <h3>Mô tả sách</h3>
                    <p>
                        {!! $book->description !!}
                    </p>
                </div>
                <div class="book-detail-content__tag">
                    @foreach ($book->categories as $cate)
                        <button>{{ $cate->name }}</button>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="book-comment data-tabs">
            <div class="book-comment__tab">
                <ul class="nav nav-tabs">
                    <li>
                        <a class="book-comment__button book-comment__button--active" data-toggle="tab" href="#comment-tab">Bình luận</a>
                    </li>
                    <li>
                        <a class="book-comment__button" data-toggle="tab" href="#review-tab">Phản hồi </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="book-comment__body tab-pane in active" id="comment-tab">
                    @include('client.blocks.commentsDisplay', ['comments' => $book->comments, 'book_id' => $book->id])
                    <h3 class="h3">Bình luận</h3>
                    <form method="post" action="{{ route('comments.store') }}">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name=body></textarea>
                            <input type=hidden name=book_id value="{{ $book->id }}" />
                        </div>
                        <div class="form-group">
                            <input type=submit class="btn btn-success" value="Gửi" />
                        </div>
                    </form>
                </div>
    
                <div class="book-comment__body tab-pane" id="review-tab">
    
                    <h3 class="h3">Phản hồi</h3>
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
                                        @if ($loop->index <= 4)
                                            <div class="col-3">
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
        </div>
    </main>

@endsection
