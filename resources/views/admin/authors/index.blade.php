@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tác giả</h6>
    </div>
    
    <!-- Tabs content -->
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active">Danh sách<span>({{count($authors)}})</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('author.trashlist')}}">Thùng rác</a>
                </li>
            </ul>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tên')</th>
                        <th>Ảnh đại diện</th>
                        <th>@sortablelink('date_birt','Ngày sinh')</th>
                        <th class="text-center">
                            <a href="{{route('author.create')}}" class="btn btn-dark btn-sm">Thêm mới </a>
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @if (count($authors)>0)
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
                    @else
                    <tr>
                        <td colspan="5" class="text-center">Không tìm thấy tác giả nào !</td>
                    </tr>
                    @endif

                </tbody>
            </table>
            <div class="d-flex justify-content-between">
                <form action="" method="get" id="form-page-size">
                    <select name="page_size" id="page_size" class="form-control">
                        <option value="5" @if ($pagesize==5) selected @endif>5</option>
                        <option value="10" @if ($pagesize==10) selected @endif>10</option>
                        <option value="15" @if ($pagesize==15) selected @endif>15</option>
                    </select>
                </form>
                {!!$authors->links('vendor.pagination.bootstrap-4')!!}
            </div>
        </div>
    </div>
</div>
<script>
    $('#ex1').tab();
</script>
@endsection