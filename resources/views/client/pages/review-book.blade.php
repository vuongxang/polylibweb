@extends('client.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/book-order.css') }}">
@endsection

@section('content')
    <form action="{{ route('bookStar') }}" method="POST">
        @csrf
        <div class="card">
            <div class="container-fliud">
                <div class="wrapper row">
                    <div class="details">
                        <div class="rating">
                            <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5"
                                data-step="1" value="{{ $book->userAverageRating }}" data-size="xs">
                            <input type="hidden" name="id" required="true" value="{{ $book->id }}">
                            <textarea type="text" name="body" class="form-control"></textarea>
                            <span class="review-no">112 reviews</span>
                            <br />
                            <button class="btn btn-success">Submit
                                Review</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
