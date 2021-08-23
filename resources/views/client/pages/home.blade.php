@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/home.css')}}">
@endsection
@section('title','Trang Chủ')
@section('content')

<main>
    <div id="bannerSlide" class="carousel slide " data-interval="3000" data-ride="carousel">

        <ol class="carousel-indicators">
            <li data-target="#bannerSlide" data-slide-to="0" class="active"></li>
            <li data-target="#bannerSlide" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner carousel-inner--custom ">
            <div class="carousel-item active ">
                <div class="banner banner-first">
                    <div class="banner-content">
                        <div class="banner-content__heading">
                            <h2>Website thư viện điện tử PolyLib</h2>
                            <p class="banner-content__quote">
                                Website thư viện điện tử PolyLib là thư viện của trường FPT Polytechnic với những sách đã được FPT Polytechnic mua bản quyền từ các nhà xuất bản nổi tiếng trên thế giới, biên dịch và phát hành.
                            </p>
                        </div>
                        <div>
                            <a href="{{route('book.categories')}}" class="button  btn--view-all"> Tìm và đọc sách</a>
                        </div>
                    </div>
                    <div class="banner-image">

                        <img src="{{asset('images/banner3.svg')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="banner banner-second">
                    <div class="banner-content">
                        <div class="banner-content__heading banner-content__heading--second">
                            <h2>Thế giới là một cuốn sách mở</h2>
                            <p class="banner-content__quote banner-content__quote--second ">
                                Những quyển sách làm say mê ta đến tận tủy, chúng nói chuyện với ta, cho ta những lời khuyên và liên kết với ta bởi một tình thân thật sống động và nhịp nhàng.
                            </p>
                        </div>
                        <div>
                            <a href="{{route('book.categories')}}" class="button  btn--view-all--second"> Tìm và đọc sách</a>
                        </div>
                    </div>
                    <div class="banner-image">
                        <img src="{{asset('images/banner2.svg')}}" alt="">
                    </div>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev ml-4" href="#bannerSlide" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true" width="25px" height="25px"></span>
            <span class="sr-only">Trước</span>
        </a>
        <a class="carousel-control-next " href="#bannerSlide" role="button" data-slide="next">
            <span class="carousel-control-next-icon mr-4" aria-hidden="true"></span>
            <span class="sr-only ">Sau</span>
        </a>
    </div>
    @if (session('message'))
        <div class="alert @if (session('alert')) {{ session('alert') }} @endif text-center">
            <h1 class="@if (session('text-alert')) {{ session('text-alert') }} @endif" style="font-size: 20pt; font-weight:700">
                {{ session('message') }}
            </h1>
        </div>
    @endif
    <div class="book-carouse">
        <div class="book-carouse__header">
            <div class="carouse-header__title">Sách mới nhất</div>
        </div>
        <div class="book-carouse__body">
            @if (count($books) > 0)
            <div id="newestListBook" class="carousel slide" data-interval="6000" data-ride="carousel">

                <!-- Carouse Content -->
                <div class="carousel-inner">
                    <!-- Carouse Item -->
                    @if (count($books) > 0)
                    <div class="carousel-item active">
                        <div class="book-carousel__wrapper">
                            @foreach ($books as $book)
                            @if ($loop->index < 4) <div class="book-card ">
                                <div class="book-card__img">
                                    <a href="{{ route('book.detail', $book->id) }}">
                                        <img src="{{ $book->image }}" alt="" />
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
                                    <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a>
                                    @else
                                    <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} ,</a>
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
                                @if(Auth::user())
                                <div class="book-card__btn">
                                    @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                    <a href="{{ route('book.read', $book->id) }}" class="review-btn">Đọc sách</a>
                                    @else
                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                    <a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                    @endif

                                </div>

                                @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if (count($books) > 4)
                <div class="carousel-item">
                    <div class="book-carousel__wrapper">

                        @foreach ($books as $book)
                        @if ($loop->index >= 4 && $loop->index < 8) <div class="book-card ">
                            <div class="book-card__img">
                                <a href="{{ route('book.detail', $book->id) }}">
                                    <img src="{{ $book->image }}" alt="" />
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
                                <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a>
                                @else
                                <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} ,</a>
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
                            @if(Auth::user())
                            <div class="book-card__btn">
                                @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                <a href="{{ route('book.read', $book->id) }}" class="review-btn">Đọc sách</a>
                                @else
                                <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                <a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                @endif

                            </div>

                            @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>


        @if (count($books) > 4)

        <a class="carousel-control-prev carousel-custom-prev " href="#newestListBook" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next carousel-custom-next" href="#newestListBook" role="button" data-slide="next">
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
    <div class="book-carouse book-carouse-background">
        <div class="book-carouse__header">
            <div class="carouse-header__title">Sách có lượt mượn nhiều nhất</div>
        </div>
        <div class="book-carouse__body">
            @if (count($books) > 0)
            <div id="carouselExampleControls" data-interval="9000" class="carousel slide" data-ride="carousel">

                <!-- Carouse Content -->
                <div class="carousel-inner">
                    <!-- Carouse Item -->
                    @if (count($books) > 0)
                    <div class="carousel-item active">
                        <div class="book-carousel__wrapper">
                            @foreach ($books as $book)
                            @if ($loop->index < 4) <div class="book-card ">
                                <div class="book-card__img">
                                    <a href="{{ route('book.detail', $book->id) }}">
                                        <img src="{{ $book->image }}" alt="" />
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
                                    <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a>
                                    @else
                                    <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} ,</a>
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
                                @if(Auth::user())
                                <div class="book-card__btn">
                                    @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                    <a href="{{ route('book.read', $book->id) }}" class="review-btn">Đọc sách</a>
                                    @else
                                    <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                    <a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                    @endif

                                </div>

                                @endif
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endif
                @if (count($books) > 4)
                <div class="carousel-item">
                    <div class="book-carousel__wrapper">

                        @foreach ($books as $book)
                        @if ($loop->index >= 4 && $loop->index < 8) <div class="book-card ">
                            <div class="book-card__img">
                                <a href="{{ route('book.detail', $book->id) }}">
                                    <img src="{{ $book->image }}" alt="" />
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
                                <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} </a>
                                @else
                                <a href="{{route('author.detail',$author->id)}}"> {{ $author->name }} ,</a>
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
                            @if(Auth::user())
                            <div class="book-card__btn">
                                @if(DB::table('orders')->where('book_id', $book->id)->where('id_user', Auth::user()->id)->where('status', 'Đang mượn')->first() )
                                <a href="{{ route('book.read', $book->id) }}" class="review-btn">Đọc sách</a>
                                @else
                                <a href="{{ route('Book.Order', $book->id) }}" class="borrow-btn">Mượn sách</a>
                                <a href="{{ route('book.read', $book->id) }}" class="review-btn">Xem trước</a>
                                @endif

                            </div>

                            @endif
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>


        @if (count($books) > 4)

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


</main>
@endsection