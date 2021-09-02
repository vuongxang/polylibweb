@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tác giả</h6>
    </div>
    <div class="card-body ">
        <div class="table-responsive">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('author.index')}}">Danh sách <span>( {{$authors->total()}} )</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active ">Thùng rác <span>( {{$authors_trashed->total()}} )</span></a>
                </li>
            </ul>
            <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th >@sortablelink('id','ID')</th>
                        <th >@sortablelink('name','Tên')</th>
                        <th class="text-center">Ảnh đại diện</th>
                        <th class="text-center">@sortablelink('date_birth','Ngày sinh')</th>
                        <th class="text-center" style="width: 200px;">
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if (count($authors_trashed)>0)
                <tbody>
                    @foreach ($authors_trashed as $key=>$author)
                    <tr>
                        <td>{{$author->id}}</td>
                        <td>{{$author->name}}</td>
                        <td class="text-center">
                            <img src="{{asset($author->avatar)}}" alt="" width="50">
                        </td>
                        <td class="text-center">
                            {{$author->date_birth}}
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{route('author.restore',['id' => $author->id])}}" class="btn btn-sm btn-outline-success btn-acction">Khôi phục</a>
                                <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('author.forcedelete',['id' => $author->id])}}" class="ml-1 btn btn-sm btn-outline-danger btn-acction">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">Thùng rác rỗng!</td>
                    </tr>
                </tbody>
                @endif
            </table>
            <div class="text-center d-flex justify-content-center">{!!$authors->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection