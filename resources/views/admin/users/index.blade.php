@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <div class="data-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Tài khoản nhân viên</a></li>
                    <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Tài khoản bị khóa</a></li>
                </ul>
    
                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>@sortablelink('name','Tên')</th>
                                    <th>@sortablelink('email','Email')</th>
                                    <th class="text-center">Ảnh </th>
                                    <th>@sortablelink('role_id','Vai trò')</th>
                                    <th>@sortablelink('created_at','Ngày tạo')</th>
                                    <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                                    <th class="text-center">
                                        Hành động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key=>$user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td class="text-center">
                                            <img src="{{asset($user->avatar)}}" alt="" style="width:50px;height:50px" class="img-thumbnail rounded-circle">
                                        </td>
                                        <td>
                                        {{$user->role->name}}
                                        </td>
                                        <td>
                                            {{date_format($user->created_at,"Y-m-d")}}
                                        </td>
                                        <td>
                                            {{date_format($user->updated_at,"Y-m-d")}}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('user.edit',['id' => $user->id])}}" class="fa fa-edit text-success p-1 btn-action"></a>
                                            @if (Auth::user()->id != $user->id)
                                                <a onclick="return confirm('Bạn chắc chắn muốn khóa tài khoản này?')" href="{{route('user.destroy',['id' => $user->id])}}" class="fas fa-lock text-danger p-1 btn-action"></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!!$users->links('vendor.pagination.bootstrap-4')!!}
                    </div>
                    <div id="menu1" class="tab-pane">
                        <table id="example" class="table table-bordered" style="width:100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>@sortablelink('name','Tên')</th>
                                    <th>@sortablelink('email','Email')</th>
                                    <th>Avatar</th>
                                    <th>@sortablelink('role_id','Vai trò')</th>
                                    <th>@sortablelink('created_at','Ngày tạo')</th>
                                    <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                                    <th>
                                        Hành động
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users_locked as $key=>$user)
                                    @if ($user->role_id == 1 || $user->role_id==2)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>
                                                <img src="{{asset($user->avatar)}}" alt="" width="50" class="img-thumbnail rounded-circle">
                                            </td>
                                            <td>
                                            {{$user->role->name}}
                                            </td>
                                            <td>
                                                {{date_format($user->created_at,"Y-m-d")}}
                                            </td>
                                            <td>
                                                {{date_format($user->updated_at,"Y-m-d")}}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route('user.restore',['id' => $user->id])}}" class="text-success">Khôi phục</a>
                                                @if (Auth::user()->id != $user->id)
                                                    <a onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')" href="{{route('user.forcedelete',['id' => $user->id])}}" class="text-danger p-1 btn-action">Xóa</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        {!!$users_locked->links('vendor.pagination.bootstrap-4')!!}
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">{!!$users->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>


@endsection