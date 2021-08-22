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
            <div class="d-flex justify-content-between ">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active">Danh sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('book.trashlist')}}">Thùng rác</a>
                    </li>
                </ul>
                <div>
                    <form action="" method="get" id="form-page-size">
                        <select name="page_size" id="page_size" class="form-control">
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="25" @if ($pagesize==25) selected @endif>25</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
            </div>
            <table class="table table-hover table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tiêu đề')</th>
                        <th>Ảnh</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Nội dung</th>
                        {{-- <th>@sortablelink('publish_date_from','Ngày đăng')</th> --}}
                        <th>@sortablelink('status','Trạng thái')</th>
                        <th class="text-center">
                            <a href="{{route('book.create')}}" class="btn btn-dark btn-sm shadow rounded-0"><i class="fas fa-plus-circle mr-1"></i>Thêm mới</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($books)>0)
                    @foreach ($books as $key=>$book)
                    <tr>
                        <td>{{$book->id}}</td>
                        <td>{{$book->title}}</td>
                        <td>
                            <img src="{{asset($book->image)}}" alt="" width="30" class="">
                        </td>
                        <td>
                            @foreach ($book->authors as $author)
                            <span>{{$author->name}}<span></br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($book->categories as $cate)
                            <span>{{$cate->name}}<span></br>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-lg rounded-pill" data-toggle="modal" data-target="#gallery-{{$book->id}}">
                                Ảnh
                            </button>
                        </td>
                        <td class="text-center">
                            {{-- <input data-id="{{$book->id}}" class="toggle-class-book" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $book->status ? 'checked' : '' }}> --}}
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input toggle-class-book" data-id="{{$book->id}}" data-on="On" data-off="Off" data-on="On" data-off="Off" {{ $book->status ? 'checked' : '' }}>
                                <span class="custom-control-indicator"></span>
                            </label>
                        </td>
                        <td class="text-center">
                            <a href="{{route('book.edit',['id' => $book->id])}}" class="fa fa-edit text-success p-1 btn-action"></a>
                            <a onclick="return confirm('Bạn chắc chuyển vào thùng rác?')" href="{{route('book.destroy',['id' => $book->id])}}" class="fas fa-trash-alt text-danger p-1 btn-action"></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">Không tìm thấy cuốn sách nào !</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="d-flex justify-content-center">{!!$books->links('vendor.pagination.bootstrap-4')!!}</div>
        </div>
    </div>
</div>


<!-- Modal -->
@foreach ($books as $book)
<div class="modal fade" id="gallery-{{$book->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{$book->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($book->bookGalleries as $gallery)
                <img src="{{asset($gallery->url)}}" alt="" class="img-thumnail" width="100">
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection