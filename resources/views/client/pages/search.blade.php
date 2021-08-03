@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/search.css') }}">
@endsection
@section('title','PolyLib')
@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <!-- <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link">
                            <li class="filter-item">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div> -->

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(function($) {
        let jsFilterItem = document.getElementsByClassName('js-filter-item');
        let jsFilterInput = document.getElementsByClassName('filter-item__input');

        let cates = []


        function GetURLParameter(sParam) {
            var sPageURL = window.location.search.substring(1);
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var sParameterName = sURLVariables[i].split('=');
                if (sParameterName[0] == sParam) {
                    return sParameterName[1];
                }
            }
        }

        const keyword = GetURLParameter('keyword')
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
                // if(Array.isArray(cates) && cates.length > 0){
                console.log(cates);
                $.ajax({
                    // headers: {
                    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    // },
                    url: '{{route("filter")}}',
                    method: "get",
                    data:
                    // jQuery.param({ cates: cates, keyword : keyword})  ,
                    {
                        cates: cates,
                        keyword: keyword
                    },

                    dataType: 'json',
                    success: function(res) {
                        const books = [...res];
                        console.log(books);
                        if (Array.isArray(books) && books.length > 0) {
                            const result = books.map((book) => {
                                return `<div class="book-card ">
                                        <div class="book-card__img">
                                            <a href="/book-detail/${book.id}">
                                                <img src="${book.image}" alt="">
                                            </a>
                                        </div>
                                        <div class="book-card__title">
                                            <a href="/book-detail/${book.id}">
                                                <h3> ${book.title} </h3>
                                            </a>
                                        </div>
                                        <div class="book-card__author">
                                        ${book.authors.map(item=>{return `${item.name}`})}
                                        </div>
                                        <div class="book-card__star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="book-card__btn">
                                            <a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                            <a href="/read-online/${book.id}" class="review-btn">Xem trước</a>
                                        </div>
                                    </div>
                                    `
                            }).join("");
                            $('#book-qty').empty();
                            $('#book-qty').append((books.length));
                            $('#js-search-text').html(`Tìm thấy <span id="book-qty">${books.length}</span> kết quả cho <span class="search-text-detail">"${keyword}"</span>`);
                            $('#js-book-card-collection').empty();
                            $('#js-book-card-collection').html(result);
                        }
                        if (Array.isArray(books) && books.length == 0) {
                            $('#js-book-card-collection').empty();
                            $('#js-search-text').html('Không tìm thấy kết quả nào');
                            console.log('Không tìm thấy kết quả nào');
                        }

                    },
                    error: function(xhr, status, error) {
                        console.log("Error!" + xhr.error);
                    },

                })
                // }
            })
        }

        $('#filter-form :checkbox').change(function() {
            if (this.checked) {
                cates.push(parseInt(this.value))
            } else {
                cates = cates.filter(cate => {
                    return cate != parseInt(this.value)
                })
            }
            $.ajax({
                
                url: '{{route("filter")}}',
                method: "get",
                data:
                {
                    cates: cates,
                    keyword: keyword
                },

                dataType: 'json',
                success: function(res) {
                    const books = [...res];
                    console.log(books);
                    if (Array.isArray(books) && books.length > 0) {
                        const result = books.map((book) => {
                            return `<div class="book-card ">
                                        <div class="book-card__img">
                                            <a href="/book-detail/${book.id}">
                                                <img src="${book.image}" alt="">
                                            </a>
                                        </div>
                                        <div class="book-card__title">
                                            <a href="/book-detail/${book.id}">
                                                <h3> ${book.title} </h3>
                                            </a>
                                        </div>
                                        <div class="book-card__author">
                                        ${book.authors.map(item=>{return `${item.name}`})}
                                        </div>
                                        <div class="book-card__star">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="book-card__btn">
                                            <a href="/book-order/${book.id}" class="borrow-btn">Mượn sách</a>
                                            <a href="/read-online/${book.id}" class="review-btn">Xem trước</a>
                                        </div>
                                    </div>
                                    `
                        }).join("");
                        $('#book-qty').empty();
                        $('#book-qty').append((books.length));
                        $('#js-search-text').html(`Tìm thấy <span id="book-qty">${books.length}</span> kết quả cho <span class="search-text-detail">"${keyword}"</span>`);
                        $('#js-book-card-collection').empty();
                        $('#js-book-card-collection').html(result);
                    }
                    if (Array.isArray(books) && books.length == 0) {
                        $('#js-book-card-collection').empty();
                        $('#js-search-text').html('Không tìm thấy kết quả nào');
                        console.log('Không tìm thấy kết quả nào');
                    }

                },
                error: function(xhr, status, error) {
                    console.log("Error!" + xhr.error);
                },

            })
        })
        for (const item of jsFilterInput) {
            item.addEventListener("click", (e) => {
                console.log(item)
                e.stopPropagation();
            })

        }
    })
</script>

@endsection