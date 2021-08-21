@extends('client.pages.information')
@section('title','PolyLib')
@section('childCss')
<link rel="stylesheet" href="{{asset('css/client/pages/notifications.css')}}">
@endsection
@section('body')


@if (session('message'))
<div class="alert alert-success text-center">
    <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
</div>
@endif

<div class="notification">

    <div class="notification-header">
        <h2 class="notification-header__h2">Thông báo</h2>
    </div>
    <div class="notification-content">
        <table id="notification-table" class="table table-hover">
            <thead>
                <tr>
                    <th >#</th>
                    <th >Tiêu đề</th>
                    <th >Nội dung</th>
                    <th class="text-center">Trạng thái</th>
                    <th >Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @if (auth()->user()->notifications->count()>0)
                @foreach (auth()->user()->notifications as $key => $notification)
                <tr>
                    <td width="20px">{{ $key + 1 }}</td>
                    <td width="150px">{{ $notification->data['title'] }}</td>
                    <td width="320px"><a class ="notification__link"href="{{route('notification.read',$notification->id)}}">{!! $notification->data['content'] !!}</a></td>
                    <td width="120px" class="text-center">
                        @if ($notification->read_at)
                        <span class="badge badge-info bg-success ">Đã xem</span>
                        @else
                        <span class="badge badge-info bg-secondary">Chưa đọc</span>
                        @endif
                    </td>
                    <td width="130px">{{ Carbon\Carbon::parse($notification->created_at)->locale('vi')->diffForHumans() }}</td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center">Bạn chưa có thông báo nào!</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>


@endsection