@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/infomation.css')}}">
@endsection

@section('content')


@if (session('message'))
    <div class="alert alert-success text-center">
        <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
    </div>
@endif

<div class="container">
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <h2>Thông báo của tôi</h2>
            </div>
        </div>
        <table id="example" class="table border-0">
            <thead>
                <tr>
                    <td>STT</td>
                    <td>Title</td>
                    <td>Nội dung</td>
                    <td>Trạng thái</td>
                    <td>Thời gian</td>
                </tr>
            </thead>
            <tbody>
                @if (auth()->user()->notifications->count()>0)
                    @foreach (auth()->user()->notifications as $key => $notification)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $notification->data['title'] }}</td>
                            <td>{!! $notification->data['content'] !!}</td>
                            <td>
                                @if ($notification->read_at)
                                <span class="badge badge-info bg-success">Đã xem</span>
                                @else
                                <span class="badge badge-info bg-danger">Chưa đọc</span>
                                @endif
                            </td>
                            <td>{{ $notification->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">Không có thông báo nào !</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection