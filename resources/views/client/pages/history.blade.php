@extends('client.layouts.index')

@section('css')

<link rel="stylesheet" href="{{ asset('css/client/pages/history.css') }}">
@endsection

@section('title', 'PolyLib')
@section('content')
<div class="container">
    <div class=" profile-info">
        <div class="row ho-so-ca-nhan">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Lịch sử mượn sách</h2>
            </div>
        </div>
        @if (session('message'))
        <div class="alert alert-success text-center">
            <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
        </div>
        @endif
        <div class="data-tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Sách đang mượn</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Sách đã trả</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <table id="example" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh bìa</th>
                                <th>Tên sách</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($book_order) > 0)
                            @foreach ($book_order as $key => $order_book)
                                @if (!$order_book->book)
                                    <tr>
                                        <td data-label="STT" scope="row">{{ $key + 1 }}</td>
                                        <td  data-label="Trạng thái" colspan="3" class="text-center"> <span class="text-danger">Hiện bạn không thể đọc cuốn sách này !</span> </td>
                                        <td data-label="Hành động" width="400">
                                            <a class="btn btn-danger" href="{{ route('deleted.book', ['id' => $order_book->id]) }}">Trả sách</a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td data-label="STT" scope="row">{{ $key + 1 }}</td>
                                        <td data-label="Ảnh" class="img-center">
                                            <a href="{{route('book.detail',$order_book->book->slug)}}">
                                                <img src="{{ asset($order_book->book->image) }}" width="40" alt="Ảnh bìa">
                                            </a>
                                        </td>
                                        <td data-label="Tên sách">
                                            <a href="{{route('book.detail',$order_book->book->slug)}}" style="color:#000">
                                                {{ $order_book->book->title }}
                                            </a>
                                        </td>
                                        <td data-label="Trạng thái">{{ $order_book->status }}</td>
                                        <td data-label="Hoạt động" width="400">
                                            <a href="{{ route('deleted.book', ['id' => $order_book->id]) }}"
                                                onclick="return Deleted_at()" class="btn btn-danger">Trả sách</a>
                                            <a href="{{route('book.read',$order_book->book->slug)}}" class="btn btn-dark">Đọc
                                                sách</a>
                                            <a href="{{ route('book.rate', $order_book->book_id) }}"
                                                class="btn btn-success">Đánh giá</a>
                                        </td>
                                    </tr>
                                @endif
                            
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">Bạn chưa mượn cuốn sách nào!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div id="menu1" class="tab-pane">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh bìa</th>
                                <th>Tên sách</th>
                                <th>Trạng thái</th>
                                <th>Ngày trả</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($deleted_book_order)>0)
                                @foreach ($deleted_book_order as $key => $deleted_order)
                                    @if ($deleted_order->id == true && $deleted_order->book)
                                        <tr>
                                            <td data-label="STT">{{ $key + 1 }}</td>
                                            <td data-label="Ảnh" class="img-center">
                                                <a href="{{route('book.detail',$deleted_order->book->slug)}}">
                                                    <img src="{{ asset($deleted_order->book->image) }}" width="50" alt="Ảnh bìa">
                                                </a>
                                            </td>
                                            <td data-label="Tên sách">
                                                <a href="{{route('book.detail',$deleted_order->book->slug)}}" style="color:#000">
                                                    {{ $deleted_order->book->title }}
                                                </a>
                                            <td data-label="Trạng thái">{{ $deleted_order->status }}</td>
                                            <td data-label="Ngày trả">{{ $deleted_order->deleted_at->toDateString() }}</td>
                                            <td  data-label="Hoạt động">
                                                <a href="{{ route('book.detail', ['slug' => $deleted_order->book->slug]) }}"
                                                    class="btn btn-warning">Mượn lại</a>
                                                <a href="{{ route('book.rate', $deleted_order->book_id) }}"
                                                    class="btn btn-success">Đánh giá</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">Bạn chưa trả cuốn sách nào!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection