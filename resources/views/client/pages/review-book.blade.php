@extends('client.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/book-order.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form action="{{ route('bookStar') }}" method="POST">
                        {{ csrf_field() }}
                    <div class="card">
                        <div>
                            <div class="wrapper row">
                                <div class="preview col-md-6">
                                    <div class="preview-pic tab-content">
                                      <div class="tab-pane active" id="pic-1"><img src="{{asset($book->image)}}" /></div>
                                    </div>
                                </div>
                                <div class="details col-md-6">
                                    <h3 class="mt-2 mb-2">{{$book->title}}</h3>
                                    <div class="rating">
                                        <input id="input-1" name="rate" class="rating rating-loading" data-min="0" data-max="5" data-step="1" value="" data-size="xs">
                                        <input type="hidden" name="id" required="" value="{{$book->id}}">
                                        <div class="form-group">
                                            <textarea name="body" id="" class="form-control" rows="10"></textarea>
                                        </div>
                                        <span class="review-no">422 reviews</span>

                                        <div class="form-group">
                                            <button class="btn btn-success">Đánh giá</button>
                                        </div>
                                    </div>
                                    <div class="product-description">{!!$book->description!!}</div>
                                    <h4 class="author">{{$book->authors}}</h4>
                                    <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87 votes)</strong></p>
                                    
                                    <div class="action">
                                        <button class="add-to-cart btn btn-default" type="button">add to cart</button>
                                        <button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
