@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Ảnh</th>
                        <th>Tác giả</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>
                            <a href="{{route('book.create')}}" class="btn btn-dark">Add new</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($books as $key=>$book)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$book->title}}</td>
                            <td>
                                <img src="{{asset($book->image)}}" alt="" width="50">
                            </td>
                            <td>
                                @foreach ($book->authors as $author)
                                    <a href="" class="bg-primary text-white">{{$author->name}}</a>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($book->categories as $cate)
                                    <a href="" class="bg-dark text-white">{{$cate->name}}</a>
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                <input data-id="{{$book->id}}" class="toggle-class-book" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Show" data-off="Hide" {{ $book->status ? 'checked' : '' }}>
                            </td>
                            <td>
                                <div class="btn-group">
                                    {{-- <a href="{{route('book.edit',['id' => $book->id])}}" class="fa fa-edit btn btn-success"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('book.destroy',['id' => $book->id])}}" class="fas fa-trash-alt btn btn-danger"></a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>{{ $books->links() }}</div>
        </div>
    </div>
</div>
@endsection