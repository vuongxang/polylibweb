@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <div class="data-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Bình luận đã duyệt</a></li>
                    <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Bình luận chờ duyệt</a></li>
                    <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Bình luận bị xóa</a></li>
                </ul>
    
                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>email</th>
                                    <th>Tên</th>
                                    <th>Tên Sách</th>
                                    <th>Ảnh bìa</th>
                                    <th>Nội dung</th>
                                    <th>@sortablelink('created_at','Ngày bình luận')</th>
                                    <th>
                                        Hành động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments_approved as $key=>$comment)
                                    <tr>
                                        <td>{{$comment->id}}</td>
                                        <td>{{$comment->user->email}}</td>
                                        <td>{{$comment->user->name}}</td>
                                        <td>{{$comment->book->title}}</td>
                                        <td>
                                            <img src="{{asset($comment->book->image)}}" alt="" width="50" class="img-thumbnail">
                                        </td>
                                        <td>{{$comment->body}}</td>
                                        <td>
                                            {{date_format($comment->created_at,"Y-m-d")}}
                                        </td>
                                        <td class="text-center">
                                            <a href="" class="fas fa-eye text-warning p-1 btn-action"></a>
                                            <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')" href="" class="fas fa-trash text-danger p-1 btn-action"></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!!$comments_approved->links('vendor.pagination.bootstrap-4')!!}
                    </div>
                    <div id="menu1" class="tab-pane">
                        aaaaaaaaaaaaaaa
                    </div>
                </div>
            </div>
            {{-- <div class="d-flex justify-content-center">{!!$users->links('vendor.pagination.bootstrap-4')!!}</div> --}}
        </div>
    </div>
</div>


@endsection