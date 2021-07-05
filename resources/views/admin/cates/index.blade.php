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
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên danh mục')</th>
                        <th>Ảnh</th>
                        <th>@sortablelink('created_at','Ngày tạo')</th>
                        <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th>@sortablelink('status','Trạng thái')</th>
                        <th>
                            <a href="{{route('cate.create')}}" class="btn btn-dark">Add new</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cates as $key=>$cate)
                        <tr>
                            <td>{{$cate->id}}</td>
                            <td>{{$cate->name}}</td>
                            <td>
                                <img src="{{asset($cate->image)}}" alt="" width="70">
                            </td>
                            <td>{{$cate->created_at}}</td>
                            <td>{{$cate->updated_at}}</td>
                            <td>
                                {{-- <input data-id="{{$cate->id}}" data-width="75" data-height="15" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}> --}}
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$cate->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}>
                                    <span class="custom-control-indicator"></span>
                                </label>
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
            <div class="d-flex justify-content-center">{!!$cates->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection