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
                  <a class="nav-link" href="{{route('book.index')}}">Danh sách</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active">Thùng rác</a>
                  </li>
            </ul>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tiêu đề')</th>
                        <th>Ảnh</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        {{-- <th>@sortablelink('publish_date_from','Ngày đăng')</th> --}}
                        <th>@sortablelink('status','Trạng thái')</th>
                        <th class="text-center">
                            Hành động
                        </th>
                    </tr>
                </thead>
                @if (count($books)>0)
                <tbody>
                    @foreach ($books as $key=>$book)
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
                        <td class="text-center">
                            {{-- <input data-id="{{$book->id}}" class="toggle-class-book" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $book->status ? 'checked' : '' }}> --}}
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-class-book" data-id="{{$book->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $book->status ? 'checked' : '' }}>
                                <span class="custom-control-indicator"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <a href="{{route('book.restore',['id' => $book->id])}}" class="mr-2 text-success">Khôi phục</a> |
                            <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('book.forcedelete',['id' => $book->id])}}" class="ml-2 text-danger">Xóa</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @else
                    <tbody >
                        <tr>
                            <td colspan="7" class="text-center">Thùng rác rỗng!</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            <div class="d-flex justify-content-center">{!!$books->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>
@endsection
