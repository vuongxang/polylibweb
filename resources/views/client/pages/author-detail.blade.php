@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/author-detail.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="grid-custom">
    <div class="row">
        <div class="col-md-3 author-info">
            <div class="author-info-wrapper">
                <div class="author-avatar">
                    <img src="{{asset($author->avatar)}}" alt="">
                </div>
                <div class="author-info__name">
                    {{$author->name}}
                </div>
                <div class="author-info__dob">
                    {{date('d-m-Y', strtotime($author->date_birth)) }}
                </div>
                <div class="author-info__description">
                    {!! $author->description !!}
                </div>
            </div>

        </div>
        <div class="col-md-9 author-book__wrap">
            <div class="book-card-collection">
                @if(count($books)>0)
                @foreach($books as $book)
                <div class="book-card ">
                    <div class="book-card__img">
                        <a href="{{route('book.detail',$book->slug)}}">
                            <img src="{{asset($book->image)}}" alt="">
                        </a>
                    </div>
                    <div class="book-card__title">
                        <a href="{{route('book.detail',$book->slug)}}">
                            <h3> {{$book->title}}</h3>
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
                @endforeach
                @else
                <div>Tác giả chưa có cuốn sách nào</div>
                @endif
            </div>
            @if(isset($books) )
            {{ $books->links('vendor.pagination.category-pagination') }}
            @endif
        </div>

    </div>

</div>


@endsection