@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tác giả</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active bg-light">Danh sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('author.trashlist')}}">Thùng rác</a>
                  </li>
            </ul>
            <table class="table table-bordered bg-light" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên')</th>
                        <th>Avatar</th>
                        <th>@sortablelink('date_birt','Ngày sinh')</th>
                        <th class="text-center">
                            <a href="{{route('author.create')}}" class="btn btn-dark">Add new</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($authors as $key=>$author)
                        <tr>
                            <td>{{$author->id}}</td>
                            <td>{{$author->name}}</td>
                            <td>
                                <img src="{{asset($author->avatar)}}" alt="" width="50">
                            </td>
                            <td>
                                {{$author->date_birth}}
                            </td>
                            <td>
                                <div class="text-center">
                                    <a href="{{route('author.edit',['id' => $author->id])}}" class="fa fa-edit text-success p-1 btn-action"></a>
                                    <a onclick="return confirm('Bạn chắc chắn chuyển vào thùng rác?')" href="{{route('author.destroy',['id' => $author->id])}}" class="fas fa-trash-alt text-danger p-1 btn-action"></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{!!$authors->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection
