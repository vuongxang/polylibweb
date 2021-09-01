@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cập nhật danh mục</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-2">
            <form action="{{route('cate.update',$model->id)}}" method="post" enctype="multipart/form-data" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Tên danh mục</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="tên danh mục" name="name" value="{{ old('name',$model->name) }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Ảnh</label>
                    <button type="button" class="btn-outline-primary mb-2 btn-sm ml-2 shadow" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-camera"></i> Chọn ảnh
                    </button><br>
                    @if ($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                    @endif
                    <div class="show_image" class="mb-2">
                        <img src="{{ asset(old('image', $model->image)) }}" id="show_img" alt="" width="200">
                    </div>
                    <input type="text" id="image" name="image" hidden class="form-control" value="{{ old('image',$model->image) }}">
                   
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1" @if ($model->status == 1) selected @endif>Hiển thị</option>
                        <option value="0" @if ($model->status == 0) selected @endif>Ẩn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Thông tin chi tiết</label><br>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                    <textarea type="text" class="form-control" id="exampleInputDesc" rows="15" placeholder="Nhập thông tin chi tiết" name="description">{{ old('description',$model->description) }}</textarea>
                   
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Cập nhật</button>
                    <a href="{{route('cate.index')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
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