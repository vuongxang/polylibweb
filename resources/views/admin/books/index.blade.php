@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>@sortablelink('id','ID')</th>
                        <th>@sortablelink('name','Tiêu đề')</th>
                        <th>Ảnh</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Nội dung</th>
                        <th>@sortablelink('publish_date_from','Ngày đăng')</th>
                        <th>@sortablelink('status','Trạng thái')</th>
                        <th>
                            <a href="{{route('book.create')}}" class="btn btn-dark">Add new</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $key=>$book)
                        <tr>
                            <td>{{$book->id}}</td>
                            <td>{{$book->title}}</td>
                            <td>
                                <img src="{{asset($book->image)}}" alt="" width="50" class="img-thumbnail">
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
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gallery-{{$book->id}}">
                                    gallery
                                </button>
                            </td>
                            <td>
                                {{$book->publish_date_from}}
                            </td>
                            <td>
                                <input data-id="{{$book->id}}" class="toggle-class-book" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $book->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('book.edit',['id' => $book->id])}}" class="fa fa-edit btn btn-success"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('book.destroy',['id' => $book->id])}}" class="fas fa-trash-alt btn btn-danger"></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
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