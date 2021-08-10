@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/home.css')}}">
@endsection
@section('title','Trang Chủ')
@section('content')

<main>
    <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        </ol>
        <div class="carousel-inner carousel-inner--custom ">
            <div class="carousel-item active ">
                <div class="banner banner-first">
                    <div class="banner-content">
                        <div class="banner-content__heading">
                            <h2>POLYLIB</h2>
                            <p class="banner-content__quote">Một cuốn sách thực sự hay nên đọc trong tuổi trẻ, rồi đọc lại khi đã trưởng thành, và một nữa lúc tuổi già, giống như một tòa nhà đẹp nên được chiêm ngưỡng trong ánh bình minh, nắng trưa và ánh trăng.</p>
                        </div>
                        <button class="button btn--view-all">Đọc ngay</button>
                    </div>
                    <div class="banner-image">
                        <img src="{{asset('images/Bookmarks2.gif')}}" alt="">
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="banner banner-second">
                    <div class="banner-content">
                        <div class="banner-content__heading banner-content__heading--second">
                            <h2>POLYLIB</h2>
                            <p class="banner-content__quote banner-content__quote--second ">Đằng sau sự thành công của một người đàn ông, là hình dáng của một người phụ nữ. Còn đằng sau sự thành công của bất kì ai là ít nhất một cuốn sách, hay cả một giá sách.</p>
                        </div>
                        <button class="button btn--view-all btn--view-all--second">Đọc ngay</button>
                    </div>
                    <div class="banner-image">
                        <img src="{{asset('images/Bookmarks.gif')}}" alt="">
                    </div>
                </div>
            </div>

        </div>
        <a class="carousel-control-prev ml-4" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon " aria-hidden="true" width="25px" height="25px"></span>
            <span class="sr-only">Trước</span>
        </a>
        <a class="carousel-control-next " href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon mr-4" aria-hidden="true"></span>
            <span class="sr-only ">Sau</span>
        </a>
    </div>



    <div class="book-list book__list--nobackground">
        <div class="book-list__heading space__between">
            <h2>Sách mới nhất</h2>
            <a href="">Xem thêm</a>
        </div>
        <div id="carouselBookList-nobackground" class="carousel slide" data-ride="carousel" data-pause="hover">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <div class="row  justify-content-center">
                        @foreach ($books as $book)
                            @if($loop->index < 4) <div class="col-3  ">
                                <div class="book-item">
                                    <a href="{{route('book.detail',$book->id)}}">
                                        <img src="{{asset($book->image)}}" alt="">
                                        <h3>{{$book->title}}</h3>
                                    </a>
                                    @foreach($book->authors->take(1) as $bookAuthor)
                                    <p> <span class="book-author"> {{$bookAuthor->name}}</span></p>

                                    @endforeach
                                    <p> <span class="book-star">
                                        @for ($i = 0; $i < floor(DB::table('ratings')->where('rateable_id',$book->id)->avg('rating')) ; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </span></p>
                                </div>
                                </div>
                            @endif
                        @endforeach
                </div>
            </div>
            <div class="carousel-item ">
                <div class="row  justify-content-center">
                    @foreach ($books as $book)

                        @if($loop->index >= 4 && $loop->index <= 8) 
                        <div class="col-3  ">
                            <div class="book-item">
                                <a href="{{route('book.detail',$book->id)}}">
                                    <img src="{{asset($book->image)}}" alt="">
                                </a>
                                <a href="{{route('book.detail',$book->id)}}">
                                    <h3>{{$book->title}}</h3>
                                </a>
                                @foreach($book->authors as $bookAuthor)
                                <p> <span class="book-author"> {{$bookAuthor->name}}</span></p>

                                @endforeach
                                <p> 
                                    <span class="book-star">
                                        @for ($i = 0; $i < floor(DB::table('ratings')->where('rateable_id',$book->id)->avg('rating')) ; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                    </span>
                                </p>
                            </div>
                        </div>
                        @endif
                    @endforeach
            </div>
        </div>
    </div>
    <a class="carousel-control-prev  " href="#carouselBookList-nobackground" role="button" data-slide="prev">
        <button class="carousel-btn-custom " height="25px" width="25px"><i class="fas fa-chevron-left"></i></button>
        <!-- <span class="sr-only">Previous</span> -->
    </a>
    <a class="carousel-control-next " height="25px" width="25px" href="#carouselBookList-nobackground" role="button" data-slide="next">
        <button class="carousel-btn-custom " height="25px" width="25px"><i class="fas fa-chevron-right"></i></button>
    </a>
    </div>


    <div class="book-list book__list--background">
        <div class="book-list__heading space__between">
            <h2 style="color:#fff">Sách được đọc nhiều nhất</h2>
            <a href=""  style="color:#fff">Xem thêm</a>
        </div>
        <div id="book__list--background" class="carousel slide" data-ride="carousel" data-pause="hover">
            <div class="carousel-inner ">
                <div class="carousel-item active">
                    <div class="row  justify-content-center">
                        @foreach ($books as $book)
                        @if($loop->index < 4) <div class="col-3  ">
                            <div class="book-item">
                                <a href="{{route('book.detail',$book->id)}}">
                                    <img src="{{asset($book->image)}}" alt="">
                                </a>
                                <h3 class="text-white">{{$book->title}}</h3>
                                @foreach($book->authors->take(1) as $bookAuthor)
                                <p> <span class="book-author"> {{$bookAuthor->name}}</span></p>

                                @endforeach
                                <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                            </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
            <div class="carousel-item ">
                <div class="row  justify-content-center">
                    @foreach ($books as $book)

                    @if($loop->index >= 4 && $loop->index <= 8) <div class="col-3  ">
                        <div class="book-item">
                            <a href="{{route('book.detail',$book->id)}}">
                                <img src="{{asset($book->image)}}" alt="">
                            </a>
                            <a href="{{route('book.detail',$book->id)}}">
                                <h3 class="text-white">{{$book->title}}</h3>
                            </a>
                            @foreach($book->authors as $bookAuthor)
                            <p> <span class="book-author"> {{$bookAuthor->name}}</span></p>

                            @endforeach
                            <p> <span class="book-star"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>
                        </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        <a class="carousel-control-prev  " href="#book__list--background" role="button" data-slide="prev">
            <button class="carousel-btn-custom " height="25px" width="25px"><i class="fas fa-chevron-left"></i></button>
            <!-- <span class="sr-only">Previous</span> -->
        </a>
        <a class="carousel-control-next " height="25px" width="25px" href="#book__list--background" role="button" data-slide="next">
            <button class="carousel-btn-custom " height="25px" width="25px"><i class="fas fa-chevron-right"></i></button>
        </a>
    </div>
</main>
@endsection