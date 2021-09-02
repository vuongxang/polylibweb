@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('postCate.index')}}">Danh sách <span>( {{count($cates)}} )</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active ">Thùng rác <span>( {{$cates_trashed->total()}} )</span></a>
                </li>
            </ul>
            <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên danh mục')</th>
                        <th class="text-center">Ảnh</th>
                        <th class="text-center">@sortablelink('created_at','Ngày tạo')</th>
                        <th class="text-center">@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th class="text-center">@sortablelink('status','Trạng thái')</th>
                        <th class="text-center" style="width: 200px;">
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if ($cates_trashed->total()>0)
                <tbody>
                    @foreach ($cates_trashed as $key=>$cate)
                    <tr>
                        <td>{{$cate->id}}</td>
                        <td>{{$cate->name}}</td>
                        <td class="text-center">
                            <img src="{{asset($cate->image)}}" alt="" width="50">
                        </td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($cate->created_at))}}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($cate->updated_at))}}</td>
                        <td class="text-center">
                            <label class="custom-control custom-checkbox p-0 m-0" style="cursor: pointer;">
                                <input type="checkbox" class="custom-control-input toggle-class-post-cate p-0 m-0 " data-id="{{$cate->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}>
                                <span class="custom-control-indicator p-0 m-0 "></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{route('postCate.restore',['id' => $cate->id])}}" class="btn btn-sm btn-outline-success btn-acction">Khôi phục</a>
                                <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('postCate.forcedelete',['id' => $cate->id])}}" class="ml-2 btn btn-sm btn-outline-danger btn-acction">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center">Thùng rác rỗng!</td>
                    </tr>
                </tbody>
                @endif
            </table>
            <div class="d-flex justify-content-center">{!!$cates_trashed->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection