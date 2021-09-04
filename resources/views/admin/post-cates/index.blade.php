@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục bài viết</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <div class="d-flex justify-content-between ">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active">Danh sách <span>( {{$cates->total()}} )</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('postCate.trashlist')}}">Thùng rác <span>( {{$cates_trashed->total()}} )</span></a>
                    </li>
                </ul>
                <div>   
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size" class="form-select rounded" >
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="20" @if ($pagesize==20) selected @endif>20</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
            </div>
            <table class="table table-hover border-right border-left border-bottom table-sm rounded " id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên danh mục')</th>
                        <th class="text-center">Ảnh</th>
                        <th class="text-center">@sortablelink('created_at','Ngày tạo')</th>
                        <th class="text-center">@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th class="text-center">@sortablelink('status','Trạng thái')</th>
                        <th class="text-center">
                            <a href="{{route('postCate.create')}}" class="btn btn-primary shadow btn-sm font-weight-bold text-capitalize "><i class="fas fa-plus-circle mr-2"></i>Thêm mới</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cates)>0)
                        @foreach ($cates as $key=>$cate)
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
                                        <a href="{{route('postCate.edit',['id' => $cate->id])}}" class="fa fa-edit text-success p-1 btn-action"></a>
                                        <a onclick="return confirm('Bạn chắc chuyển danh mục vào thùng rác?')" href="{{route('postCate.destroy',['id' => $cate->id])}}" class="fas fa-trash-alt text-danger p-1 btn-action"></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">Không tìm thấy danh mục nào !</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                {!!$cates->links('vendor.pagination.bootstrap-4')!!}
            </div>
        </div>
    </div>
</div>
@endsection