@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tác giả</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên')</th>
                        <th>Avatar</th>
                        <th>@sortablelink('date_birt','Ngày sinh')</th>
                        <th>
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
                                <div class="btn-group">
                                    <a href="{{route('author.edit',['id' => $author->id])}}" class="fa fa-edit btn btn-success"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('author.destroy',['id' => $author->id])}}" class="fas fa-trash-alt btn btn-danger"></a>
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
