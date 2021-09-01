@extends('admin.layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold h6 text-primary">Thêm mới danh mục bài viết</h3>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-2">
                <form action="{{ route('postCate.store') }}" method="post" enctype="multipart/form-data"
                    class="mt-4 mb-4">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputName" class="text-dark font-weight-bold">Tên danh mục</label><br>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Tên danh mục"
                            name="name" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                    <div class="form-group">
                        <label class="text-dark font-weight-bold" for="exampleInputFile">Ảnh đại diện</label>
                        <button type="button" class="fas fa-camera btn-outline-primary mb-2 btn-sm ml-2" data-toggle="modal"
                            data-target="#exampleModal">
                            CHỌN ẢNH
                        </button>
                        <br>
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('image') }}</span>
                        @endif
                        <div class="show_image" class="mb-2">
                            <img src="" alt="" id="show_img" width="200">
                        </div>
                        <input type="text" id="image" name="image" hidden class="form-control">

                    </div>
                    <div class="form-group">
                        <label class="text-dark font-weight-bold" for="exampleSelect">Trạng thái</label>
                        <select name="status" class="form-control" id="exampleSelect">
                            <option value="1">Hiển thị</option>
                            <option value="0">Ẩn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="text-dark font-weight-bold" for="exampleInputDesc">Thông tin chi tiết</label><br>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                        <textarea type="text" class="form-control tinymce-editor" id="exampleInputDesc" rows="15"
                            placeholder="Nhập thông tin chi tiết" name="description">{{ old('description') }}</textarea>

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-dark btn-sm shadow-lg">Thêm mới</button>
                        <a href="{{ route('postCate.index') }}" class="btn btn-danger btn-sm shadow">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thư viện ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe
                        src="{{ url('') }}/filemanager/dialog.php?field_id=image&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee"
                        frameborder="0" width="100%" height="500"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary btn-sm">Lưu</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
