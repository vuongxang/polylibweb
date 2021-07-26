@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/book-detail.css') }}">
@endsection
@section('title', 'Trang Chi tiết')

@section('content')

@if (session('thongbao'))
{{--<script>
    alert("{{ session('thongbao') }}")
</script>--}}
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
                <p>Đánh giá: <span class="book-detail-content__header-star"><i class="fas fa-star"></i><i
                            class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                            class="fas fa-star"></i></span></p>
            </div>
            <div class="book-detail-content__button">
                @if (
                DB::table('orders')->where('id', $book->id)->orWhere('status','==', 'Đang mượn'))

                <a href="doc-sach" class="btn btn-success">Đọc sách</a>
    
                @else

                <a href="{{route('Book.Order',['id'=>$book->id])}}" class="borrow-btn">Mượn sách</a>
                <a class="review-btn">Xem trước</a>

                @endif
            </div>
            <div class="book-detail-content__desc">
                {!! $book->description !!}
                <h3>Mô tả sách</h3>
                <p>Robert Langdon, giáo sư biểu tượng và biểu tượng tôn giáo đến từ trường đại học Harvard, đã tới Bảo
                    tàng Guggenheim Museum Bilbao để tham dự một tuyên bố quan trọng - công bố phát hiện "sẽ thay đổi bộ
                    mặt khoa học mãi mãi".<br />

                    Edmond Kirsch - một tỷ phú bốn mươi tuổi, một nhà tiên tri với những phát minh kỹ thuật cao và những
                    dự đoán táo bạo đã làm cho anh trở thành một nhân vật nổi tiếng toàn cầu. Kirsch - cũng chính là một
                    trong những sinh viên đầu tiên của Langdon tại đại học Harvard cách đây hai thập kỷ - sẽ tiết lộ một
                    bước đột phá đáng kinh ngạc... Một trong số đó sẽ trả lời hai câu hỏi cơ bản về sự tồn tại của con
                    người:
                    <br /><br />
                    "Chúng ta đến từ đâu?" và "Chúng ta đang đi về đâu?"
                    <br /><br />
                    Khi sự kiện bắt đầu, Langdon và vài trăm quan khách cảm thấy bị cuốn hút bởi một bài thuyết trình
                    được trình hoàn toàn độc đáo, mà chính Langdon cũng nhận thấy rằng sẽ gây ra nhiều tranh cãi hơn
                    những gì ông tưởng tượng. Nhưng buổi tối được chuẩn bị chu toàn này đột nhiên biến thành sự hỗn
                    loạn, và khám phá quý giá của Kirsch đang dần dần biến mất. Trước nguy cơ phải đối mặt với một mối
                    đe dọa sắp xảy ra, Langdon bị buộc phải bỏ trốn để thoát khỏi Bilbao. Đi cùng ông là Ambra Vidal, nữ
                    giám đốc viện bảo tàng thanh lịch, người đã cùng Kirsch chuẩn bị cho sự kiện này đồng thời cũng là
                    Hoàng hậu tương lai của đất nước Tây Ban Nha. Họ cùng nhau chạy trốn đến Barcelona trong một cuộc
                    hành trình nguy hiểm để tìm ra một mật khẩu bí ẩn sẽ mở ra bí mật của Kirsch.
                    ..

                </p>
            </div>
            <div class="book-detail-content__tag">
                @foreach ($book->categories as $cate)
                <button>{{ $cate->name }}</button>
                @endforeach
            </div>
        </div>

    </div>

    <div class="book-comment">
        <div class="book-comment__tab">
            <button class="book-comment__button book-comment__button--active">Bình luận</button>
            <button class="book-comment__button">Phản hồi </button>
            <button class="book-comment__button">Đánh giá</button>
        </div>
        <div class="book-comment__body">
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

    </div>

    <div class="book-list book__list--background">
        <div class="book-list__heading space__between">
            <h2>Sách cùng thể loại</h2>
            <a href="">Xem thêm</a>
        </div>
        <div id="carouselBookCate-background" class="carousel slide" data-ride="carousel" data-pause="hover">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <div class="row  ">
                        @foreach ($book->categories as $cate)
                            @foreach ($cate->books as $b)
                                @if ($b->id != $book->id)
                                    @if ($loop->index <= 4) <div class="col-3  ">
                                        <div class="book-item">
                                            <a href="{{ route('book.detail', $b->id) }}">
                                                <img src="{{ asset($b->image) }}" alt="">
                                            </a>
                                            <a href="{{ route('book.detail', $b->id) }}">
                                                <h3>{{ $b->title }}</h3>
                                            </a>

                                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                        class="fas fa-star"></i></span>
                                            </p>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
            @if (count($book->categories) > 4)
            <div class="carousel-item ">
                <div class="row  justify-content-center">
                    @foreach ($book->categories as $booke)
                    @foreach ($cate->books as $b)
                    @if ($b->id != $book->id)
                    @if ($loop->index >= 4 && $loop->index <= 8) <div class="col-3  ">
                        <div class="book-item">
                            <a href="{{ route('book.detail', $booke->id) }}">
                                <img src="{{ asset($booke->image) }}" alt="">
                            </a>
                            <a href="{{ route('book.detail', $book->id) }}">
                                <h3>{{ $booke->slug }}</h3>
                            </a>

                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i></span></p>
                        </div>
                </div>
                @endif
                @endif
                @endforeach
                @endforeach
            </div>
            <a class="carousel-control-prev  " href="#carouselBookCate-background" role="button" data-slide="prev">
                <button class="carousel-btn-custom " height="25px" width="25px"><i
                        class="fas fa-chevron-left"></i></button>
                <!-- <span class="sr-only">Previous</span> -->
            </a>
            <a class="carousel-control-next " height="25px" width="25px" href="#carouselBookCate-background"
                role="button" data-slide="next">
                <button class="carousel-btn-custom " height="25px" width="25px"><i
                        class="fas fa-chevron-right"></i></button>
            </a>
            @endif
        </div>

    </div>


</main>
@endsection