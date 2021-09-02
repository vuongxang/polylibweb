@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tác giả</h6>
    </div>
    
    <!-- Tabs content -->
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            
            <div class="d-flex justify-content-between ">
                <ul class="nav nav-tabs">
                    <li class="nav-item bg-light">
                        <a class="nav-link active">Danh sách <span> ( {{$authors->total()}} )</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('author.trashlist')}}">Thùng rác <span> ( {{$authors_trashed->total()}} )</span></a>
                    </li>
                </ul>
                <div>
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size" class="form-select form-select-sm rounded" aria-label=".form-select-sm" >
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="25" @if ($pagesize==25) selected @endif>25</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
            </div>
            <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th >@sortablelink('id','ID')</th>
                        <th >@sortablelink('name','Tên')</th>
                        <th class="text-center">Ảnh đại diện</th>
                        <th class="text-center">@sortablelink('date_birth','Ngày sinh')</th>
                        <th class="text-center">@sortablelink('book_number','Số lượng sách')</th>
                        <th class="text-center ">
                            <a href="{{route('author.create')}}" class="btn btn-dark btn-sm shadow font-weight-bold text-capitalize"><i class="fas fa-plus-circle mr-2"></i>Thêm mới </a>
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @if (count($authors)>0)
                    @foreach ($authors as $key=>$author)
                    <tr>
                        <td >{{$author->id}}</td>
                        <td>{{$author->name}}</td>
                        <td class="text-center">
                            <img src="{{asset($author->avatar)}}" alt="" width="50">
                        </td>
                        <td class="text-center">
                            {{$author->date_birth}}
                        </td>
                        <td class="text-center">
                            {{$author->books->count()}}
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
            <div class="d-flex justify-content-center">{!!$authors->links('vendor.pagination.bootstrap-4')!!}</div>

        </div>
    </div>
</div>
<script>
    $('#ex1').tab();
</script>
@endsection