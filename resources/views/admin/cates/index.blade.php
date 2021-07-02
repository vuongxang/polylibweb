@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Trạng thái</th>
                        <th>
                            <a href="{{route('cate.create')}}" class="btn btn-dark">Add new</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cates as $key=>$cate)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$cate->name}}</td>
                            <td>
                                <img src="{{asset($cate->image)}}" alt="" width="70">
                            </td>
                            <td>
                                <input data-id="{{$cate->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('cate.edit',['id' => $cate->id])}}" class="fa fa-edit btn btn-success"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('cate.destroy',['id' => $cate->id])}}" class="fas fa-trash-alt btn btn-danger"></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{ $cates->links() }}</div>
        </div>
    </div>
</div>
@endsection