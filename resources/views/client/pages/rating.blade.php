@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/rating.css') }}">
<link rel="stylesheet" href="{{ asset('css/client/pages/book-detail.css') }}">
@endsection

@section('title', 'PolyLib')
@section('content')

<div class="container">
    <div class="book-rating__wrapper">
        <div class="row book-rating__header">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Đánh giá của tôi</h2>
            </div>
        </div>
        <div class="data-tabs book-rating__content">
            <!-- <ul class="nav nav-tabs">
                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#all">Tất cả</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#da_danh_gia">Đã đánh giá</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#chua_danh_gia">Chưa đánh giá</a></li>
            </ul> -->
            <div class="tab-content">
                <div id="da_danh_gia"  class="">
                    @if(count($user_rating)>0)
                    @foreach ($user_rating as $user_rate)
                    <table class="table table-bordered">
                        @if ($user_rate->book)
                        <div class="book-user-comment">
                            <tr>
                                <td width="100px">
                                    <div class="text-center">
                                        <a href="{{route('book.detail',$user_rate->book->slug)}}">
                                            <img width="70" src="{{ asset($user_rate->book->image) }}"
                                                alt="{{ $user_rate->book->title }}">
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        <div class="book-user-comment__heading">
                                            <div class="book-user-comment__name">
                                                <a href="{{route('book.detail',$user_rate->book->slug)}}">
                                                    {{ $user_rate->book->title }}
                                            </div>
                                            </a>
                                            <div class="book-user-comment__footer">
                                                <div class="book-user-comment__link">
                                                    <span class="book-star">
                                                        @for ($i=1; $i <= 5; $i++) @if (round($avg_rating,1)>=
                                                            round($i,1) )
                                                            <i class="fas fa-star"></i>
                                                            @else
                                                            <i class="far fa-star"></i>
                                                            @endif
                                                            @endfor
                                                            <span>
                                                </div>
                                                <div class="book-user-comment__date">
                                                    {{ date('d-m-Y', strtotime($user_rate->created_at)) }}</div>
                                            </div>
                                            <div class="book-user-comment__content text-justify">
                                                @if($user_rate->body != "")
                                                    {{ $user_rate->body }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="book-rating__user__button">
                                        <a href="{{ route('book.rate', $user_rate->book->id) }}"
                                            class="btn btn-primary btn-sm shadow rounded-0">
                                                XEM ĐÁNH GIÁ
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </div>
                        @endif
                    </table>
                    @endforeach
                    @else
                    <p class="text-center" style="font-size: 16px;">Bạn chưa đánh giá cuốn sách nào!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection