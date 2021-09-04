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
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Tài khoản nhân viên</a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Tài khoản bị khóa</a></li>
                    </ul>
                    <div>
                        <form action="" method="get" id="form-page-size">
                            <label for="">Chọn số bản ghi</label>
                            <select name="page_size" id="page_size" class="form-select rounded " aria-label=".form-select-sm" >
                                <option value="10" @if ($pagesize==10) selected @endif>10</option>
                                <option value="25" @if ($pagesize==25) selected @endif>25</option>
                                <option value="50" @if ($pagesize==50) selected @endif>50</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>@sortablelink('name','Tên')</th>
                                    <th>@sortablelink('email','Email')</th>
                                    <th class="text-center">Ảnh </th>
                                    <th class="text-center">@sortablelink('role_id','Vai trò')</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày tạo')</th>
                                    <th class="text-center">@sortablelink('updated_at','Ngày cập nhật')</th>
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
                                    <td class="text-center">
                                        {{$user->role->name}}
                                    </td>
                                    <td class="text-center">
                                        {{date_format($user->created_at,"d-m-Y")}}
                                    </td>
                                    <td class="text-center">
                                        {{date_format($user->updated_at,"d-m-Y")}}
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
                        <table id="example" class="table table-hover border-right border-left border-bottom table-sm rounded" style="width:100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>@sortablelink('name','Tên')</th>
                                    <th>@sortablelink('email','Email')</th>
                                    <th class="text-center">Avatar</th>
                                    <th class="text-center">@sortablelink('role_id','Vai trò')</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày tạo')</th>
                                    <th class="text-center">@sortablelink('updated_at','Ngày cập nhật')</th>
                                    <th class="text-center">
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
                                    <td class="text-center">
                                        <img src="{{asset($user->avatar)}}" alt="" style="width:50px;height:50px" class="img-thumbnail rounded-circle">
                                    </td>
                                    <td class="text-center">
                                        {{$user->role->name}}
                                    </td>
                                    <td class="text-center">
                                        {{date_format($user->created_at,"d-m-Y")}}
                                    </td>
                                    <td class="text-center">
                                        {{date_format($user->updated_at,"d-m-Y")}}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                                <a href="{{route('user.restore',['id' => $user->id])}}" class="btn btn-sm btn-outline-success btn-acction">Khôi phục</a>
                                            @if (Auth::user()->id != $user->id)
                                                <a onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')" href="{{route('user.forcedelete',['id' => $user->id])}}" class="ml-2 btn btn-sm btn-outline-danger btn-acction">Xóa</a>
                                            @endif
                                        </div>
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