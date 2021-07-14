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
                  <a class="nav-link" href="{{route('author.index')}}">Danh sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active bg-light">Thùng rác</a>
                  </li>
            </ul>
            <table class="table table-bordered bg-light" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên')</th>
                        <th>Avatar</th>
                        <th>@sortablelink('date_birt','Ngày sinh')</th>
                        <th>
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if (count($authors)>0)
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
                                <div class="btn-group">
                                    <a href="{{route('author.restore',['id' => $author->id])}}" class="mr-2">Khôi phục</a> |
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('author.forcedelete',['id' => $author->id])}}" class="ml-2">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                @else
                    <tbody >
                        <tr>
                            <td colspan="5" class="text-center">Thùng rác rỗng!</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <div class="d-flex justify-content-center">{!!$authors->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection
