@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/search.css') }}">
@endsection
@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link">
                            <li class="filter-item">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div>

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
                <div class="search-text">
                    Tìm kiếm kết quả cho <span class="search-text-detail">"{{$keyword}}"</span>
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
            <div class="book-card-collection">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function($) {
    let jsFilterItem = document.getElementsByClassName('js-filter-item');
    let jsFilterInput = document.getElementsByClassName('filter-item__input');

    let cates = []
    for (const item of jsFilterItem) {
        item.addEventListener("click", () => {
            if (item.querySelector('input').checked == false) {
                item.querySelector('input').checked = true;
                cates.push(parseInt(item.querySelector('input').value))
            } else {
                if (item.querySelector('input').checked == true) {
                    item.querySelector('input').checked = false;
                    cates = cates.filter(cate => {
                        return cate != parseInt(item.querySelector('input').value)
                    })
                }
            }
            $.ajax({
                // headers: {
                //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                // },
                url: '{{route("filter")}}',
                method: "get",
                data: {
                    cates: cates
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res)
                }
            })
        })
    }

    // $('#filter-form :checkbox').change(function() {
    //     if(this.checked){
    //         console.log(1);
    //     }
    // })
    for (const item of jsFilterInput) {
        item.addEventListener("click", (e) => {
            e.stopPropagation();
        })
    }})
</script>

@endsection