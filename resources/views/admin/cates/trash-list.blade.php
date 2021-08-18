@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục bài viết</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('postCate.index')}}">Danh sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active bg-light">Thùng rác</a>
                  </li>
            </ul>
            <table class="table table-bordered bg-light" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên danh mục')</th>
                        <th>Ảnh</th>
                        <th>@sortablelink('created_at','Ngày tạo')</th>
                        <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th class="text-center">
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if (count($cates)>0)
                <tbody>
                    @foreach ($cates as $key=>$cate)
                    <tr>
                        <td>{{$cate->id}}</td>
                        <td>{{$cate->name}}</td>
                        <td>
                            <img src="{{asset($cate->image)}}" alt="" width="70">
                        </td>
                        <td>{{ date('d-m-Y', strtotime($cate->created_at))}}</td>
                        <td>{{ date('d-m-Y', strtotime($cate->updated_at))}}</td>
                        <td>
                            {{-- <input data-id="{{$cate->id}}" data-width="75" data-height="15" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}> --}}
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-class" data-id="{{$cate->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}>
                                <span class="custom-control-indicator"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{route('postCate.restore',['id' => $cate->id])}}" class="mr-2 text-success">Khôi phục</a> |
                                <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('postCate.forcedelete',['id' => $cate->id])}}" class="ml-2 text-danger">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                    <tbody >
                        <tr>
                            <td colspan="6" class="text-center">Thùng rác rỗng!</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <div class="d-flex justify-content-center">{!!$cates->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection
