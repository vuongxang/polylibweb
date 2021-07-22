@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/book-order.css')}}">
@endsection

@section('content')
<div class="container">
    <div class=" profile-info">
        <div class="row ho-so-ca-nhan">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Sách đang mượn đọc</h2>
            </div>
        </div>
        @if (session('deleted_book'))
            <div class="alert alert-success text-center">
                <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('deleted_book') }}</h1>
            </div>
        @endif
        <div class="data-tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Sách đang mượn</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Sách đã trả</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Tên sách</td>
                                <td>Trạng thái</td>
                                <td>Thời gian còn lại</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($book_order as $key => $book)
                            @if ($book->id == true)
                            <?php   
                                    $time_order = strtotime($book->created_at->addDay(5));
                                    $time_now = strtotime($dt);
                                    $time = $time_order-$time_now;
                                    // dd($time_order,$time_now);
                                    $years = floor($time / (365*60*60*24));
                                    $months = floor(($time - $years * 365*60*60*24) / (30*60*60*24));
                                    $day = floor(($time - $years*365*60*60*24)/(60*60*24));
                                    
                                    // dd();

                                    $days = floor(($time - $years*365*60*60*24 - $months*30*60*60*24)/(60*60*24));
                                    $hours = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
                                    $minutes = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60) / 60);
                                    $seconds = floor(($time - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));
                                ?>
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$book->name_book}}</td>
                                <td>{{$book->status}}</td>
                                <td>

                                    {{$day}} ngày
                                    {{$hours}}:{{$minutes}}:{{$seconds}}
                                </td>
                                <td>
                                    @if($time_order + 7 == true)
                                    <a href="{{route('deleted.book',['id'=>$book->id])}}" onclick="return Deleted_at()"
                                        class="btn btn-danger">Trả sách</a>
                                    @else
                                    <a href="{{$book->id}}" class="btn btn-danger">Trả sách</a>
                                    <a href="" class="btn btn-primary">Gia hạn</a>
                                    @endif
                                    <a href="" class="btn btn-dark">Đọc sách</a>
                                    <a href="{{route('book.review',$book->id)}}" class="btn btn-success">Review</a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="menu1" class="tab-pane">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Tên sách</td>
                                <td>Trạng thái</td>
                                <td>Hành động</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deleted_book as $key => $book)
                            @if ($book->id == true)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$book->name_book}}</td>
                                <td>{{$book->status}}</td>
                                <td>
                                    <a href="{{route('book.detail', ['id'=>$book->id])}}" class="btn btn-warning">Mượn lại</a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection