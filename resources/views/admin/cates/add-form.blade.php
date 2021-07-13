@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm mới danh mục</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-2">
            <form action="{{route('cate.store')}}" method="post" enctype="multipart/form-data" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Tên danh mục</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="tên danh mục" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Ảnh</label>
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                        Chọn ảnh
                    </button>
                    <div class="show_image" class="mb-2">
                        <img src="" alt="" id="show_img" width="200">
                    </div>
                    <input type="text" id="image" name="image" hidden class="form-control">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Enable</option>
                        <option value="0">Disable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputDesc">Thông tin chi tiết</label>
                    <textarea type="text" class="form-control tinymce-editor" id="exampleInputDesc" rows="10" placeholder="Nhập thông tin chi tiết" name="description">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark rounded-pill shadow-lg">LƯU</button>
                    <a href="{{route('cate.index')}}" class="btn btn-danger rounded-pill shadow">HỦY</a>
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
          <iframe src="{{url('')}}/filemanager/dialog.php?field_id=image&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee" 
                frameborder="0" width="100%" height="500"></iframe>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Lưu</button> --}}
        </div>
      </div>
    </div>
  </div>
@endsection