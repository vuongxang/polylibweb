@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link" href="{{route('book.index')}}">Danh sách <span>({{$books->total()}})</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active ">Thùng rác({{$books_trashed->total()}})</a>
                  </li>
            </ul>
            <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th class="text-center">@sortablelink('id','ID')</th>
                        <th width="250px">@sortablelink('name','Tiêu đề')</th>
                        <th class="text-center">Ảnh</th>
                        <th class="text-center">Tác giả</th>
                        <th class="text-center">Danh mục</th>
                        {{-- <th>@sortablelink('publish_date_from','Ngày đăng')</th> --}}
                        <th class="text-center">@sortablelink('status','Trạng thái')</th>
                        <th class="text-center">
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if (count($books_trashed)>0)
                <tbody>
                    @foreach ($books_trashed as $key=>$book)
                    <tr>
                        <td>{{$book->id}}</td>
                        <td>{{$book->title}}</td>
                        <td>
                            <img src="{{asset($book->image)}}" alt="" width="30" class="">
                        </td>
                        <td>
                            @foreach ($book->authors as $author)
                                <a href="" class="">{{$author->name}}</a>,
                            @endforeach
                        </td>
                        <td>
                            @foreach ($book->categories as $cate)
                                <a href="" class="">{{$cate->name}}</a>,
                                <br>
                            @endforeach
                        </td>
                        <td>
                            {{-- <input data-id="{{$book->id}}" class="toggle-class-book" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $book->status ? 'checked' : '' }}> --}}
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-class-book" data-id="{{$book->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $book->status ? 'checked' : '' }}>
                                <span class="custom-control-indicator"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{route('book.restore',['id' => $book->id])}}" class="btn btn-sm btn-outline-success btn-acction">Khôi phục</a>
                                <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('book.forcedelete',['id' => $book->id])}}" class="ml-2 btn btn-sm btn-outline-danger btn-acction">Xóa</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                    <tbody >
                        <tr>
                            <td colspan="8" class="text-center">Thùng rác rỗng!</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <div class="d-flex justify-content-center">{!!$books->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection
