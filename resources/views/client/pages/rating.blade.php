@extends('client.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/rating.css') }}">
@endsection

@section('content')

<div class="container">
    <div class="book-rating__wrapper">
        <div class="row book-rating__header">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Đánh giá của bạn</h2>
            </div>
        </div>
        <div class="book-rating__content">
            <table>
                <thead>
                    <tr>
                        
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection