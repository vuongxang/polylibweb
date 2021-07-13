@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên')</th>
                        {{-- <th>google_id</th> --}}
                        <th>Avatar</th>
                        <th>@sortablelink('role_id','Vai trò')</th>
                        <th>@sortablelink('created_at','Ngày tạo')</th>
                        <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th>
                            {{-- <a href="{{route('book.create')}}" class="btn btn-dark">Add new</a> --}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            {{-- <td>{{$user->google_id}}</td> --}}
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
                            <td>
                                {{-- <input data-id="{{$user->id}}" class="toggle-class-user" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $user->status ? 'checked' : '' }}> --}}
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input toggle-class-user" data-id="{{$user->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $user->status ? 'checked' : '' }}>
                                    <span class="custom-control-indicator"></span>
                                </label>
                            </td>
                            {{-- <td>
                                <div class="btn-group">
                                    <a href="{{route('user.edit',['id' => $user->id])}}" class="fa fa-edit btn btn-success"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('user.destroy',['id' => $user->id])}}" class="fas fa-trash-alt btn btn-danger"></a>
                                </div>
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{!!$users->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>

@endsection