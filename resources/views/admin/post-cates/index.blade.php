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
            <div class="d-flex justify-content-between border-bottom">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active">Danh sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('postCate.trashlist')}}">Thùng rác</a>
                    </li>
                </ul>
                <div>   
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size" class="form-select mt-2" >
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="20" @if ($pagesize==20) selected @endif>20</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
            </div>
            <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên danh mục')</th>
                        <th class="text-center">Ảnh</th>
                        <th>@sortablelink('created_at','Ngày tạo')</th>
                        <th>@sortablelink('updated_at','Ngày cập nhật')</th>
                        <th>@sortablelink('status','Trạng thái')</th>
                        <th class="text-center">
                            <a href="{{route('postCate.create')}}" class="btn btn-dark btn-sm shadow rounded-0"><i class="fas fa-plus-circle mr-1"></i>Thêm mới</a>
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
                                <td>{{ date('d-m-Y', strtotime($cate->created_at))}}</td>
                                <td>{{ date('d-m-Y', strtotime($cate->updated_at))}}</td>
                                <td>
                                    {{-- <input data-id="{{$cate->id}}" data-width="75" data-height="15" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}> --}}
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input toggle-class-post-cate" data-id="{{$cate->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $cate->status ? 'checked' : '' }}>
                                        <span class="custom-control-indicator"></span>
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
                            <td colspan="6" class="text-center">Không tìm thấy danh mục nào !</td>
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