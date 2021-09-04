@extends('admin.layouts.main')
@section('content')


<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thông báo</h6>
    </div>
    <div class="card-body p-2">
        <div class="table-responsive panel panel-default">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            
            <table class="table  rounded  " id="dataTable" width="100%" cellspacing="0">
                <thead >
                    <tr >
                        <th class="rounded-top font-weight-bold">#</th>
                        <th class="font-weight-bold">Tiêu đề</th>
                        <th class="font-weight-bold"> Nội dung</th>
                        <th class="text-center font-weight-bold">Trạng thái</th>
                        <th class="font-weight-bold">Thời gian</th>
                    </tr>
                </thead>
                <tbody >
                    @if (auth()->user()->notifications->count()>0)
                    @foreach ($notifications as $key => $notification)
                    <tr>
                        <td width="20px">{{ $key + 1 }}</td>
                        <td width="150px">{{ $notification->data['title'] }}</td>
                        <td width="320px"><a class="notification__link" href="{{route('notification.read',$notification->id)}}">{!! $notification->data['content'] !!}</a></td>
                        <td width="120px" class="text-center">
                            @if ($notification->read_at)
                            <span class="badge badge-info bg-success  ">Đã xem</span>
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
            <div class="d-flex justify-content-between">
                {!!$notifications->links('vendor.pagination.bootstrap-4')!!}
            </div>
        </div>
    </div>
</div>









@endsection