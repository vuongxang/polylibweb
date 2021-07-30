@extends('client.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/book-order.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class=" profile-info">
            <div class="row ho-so-ca-nhan">
                <div class="col-md-12 ho-so-ca-nhan">
                    <h2>Lịch sử mượn sách</h2>
                </div>
            </div>
            @if (session('message'))
                <div class="alert 
                    @if (session('alert'))
                        {{session('alert')}}
                    @endif
                text-center">
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
                                    <td>STT</td>
                                    <td>Ảnh bìa</td>
                                    <td>Tên sách</td>
                                    <td>Trạng thái</td>
                                    <td>Thời gian còn lại</td>
                                    <td>Hành động</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($book_order) > 0)
                                    @foreach ($book_order as $key => $order_book)
                                        <?php
                                        $time_order = strtotime($order_book->created_at->addDays(3));
                                        $time_now = strtotime($dt);
                                        $time = $time_order - $time_now;
                                        // dd($time_order + strtotime(0000-00-07));
                                        $years = floor($time / (365 * 60 * 60 * 24));
                                        $months = floor(($time - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                                        $day = floor(($time - $years * 365 * 60 * 60 * 24) / (60 * 60 * 24));
                                        
                                        // dd();
                                        
                                        $days = floor(($time - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                                        $hours = floor(($time - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
                                        $minutes = floor(($time - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
                                        $seconds = floor($time - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60);
                                        ?>
                                        <tr>
                                            <td scope="row">{{ $key + 1 }}</td>
                                            <td class="text-center">
                                                <a href="{{route('book.detail',$order_book->book->id)}}">
                                                    <img src="{{ $order_book->book->image }}" width="50" alt="Ảnh bìa">
                                                </a>
                                            </td>
                                            <td>{{ $order_book->book->title }}</td>
                                            <td>{{ $order_book->status }}</td>
                                            <td>
                                                @if ($day > 0)
                                                    {{ $day }} ngày
                                                    {{ $hours }}:{{ $minutes }}:{{ $seconds }}
                                                @elseif ($hours > 0 || $minutes > 0 || $seconds > 0)
                                                    {{ $hours }}:{{ $minutes }}:{{ $seconds }}
                                                @elseif ($day<=0 && $hours<=0 && $minutes<=0 && $seconds<=0) abc
                                                        @endif
                                            </td>
                                            <td width="400">
                                                <a href="{{ route('deleted.book', ['id' => $order_book->id]) }}"
                                                    onclick="return Deleted_at()" class="btn btn-danger">Trả sách</a>
                                                <a href="{{route('book.read',$order_book->book_id)}}" class="btn btn-dark">Đọc sách</a>
                                                <a href="{{ route('book.review', $order_book->book_id) }}"
                                                    class="btn btn-success">Phản hồi/Đánh giá</a>
                                            </td>
                                        </tr>
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
                                    <td>STT</td>
                                    <td>Ảnh bìa</td>
                                    <td>Tên sách</td>
                                    <td>Trạng thái</td>
                                    <td>Ngày trả</td>
                                    <td>Hành động</td>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($deleted_book_order)>0)                                
                                    @foreach ($deleted_book_order as $key => $deleted_order)
                                        @if ($deleted_order->id == true)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td class="text-center">
                                                    <a href="{{route('book.detail',$deleted_order->book->id)}}">
                                                        <img src="{{ $deleted_order->book->image }}" width="50" alt="Ảnh bìa"> 
                                                    </a>
                                                </td>
                                                <td>{{ $deleted_order->book->title }}</td>
                                                <td>{{ $deleted_order->status }}</td>
                                                <td>{{ $deleted_order->deleted_at }}</td>
                                                <td>
                                                    <a href="{{ route('book.detail', ['id' => $deleted_order->book_id]) }}"
                                                        class="btn btn-warning">Mượn lại</a>
                                                    <a href="{{ route('book.review', $deleted_order->book_id) }}" 
                                                        class="btn btn-success">Phản hồi/Đánh giá</a>
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
