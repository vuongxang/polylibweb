@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm mới tác giả</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-2">
            <form action="{{route('author.store')}}" method="post" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Tên tác giả</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Tên tác giả" name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Ảnh đại diện</label>
                    <button type="button" class="btn btn-primary mb-2 btn-sm" data-toggle="modal" data-target="#exampleModal">
                        Chọn ảnh
                    </button>
                    <div class="show_image" class="mb-2" style="width:200px; height:300px; border:1px solid #bdbdbd">
                        <img src="" alt="Ảnh tác giả" id="show_img" width="200" height="300px" readonly>
                    </div>
                    <input type="text" id="image" hidden name="avatar" class="form-control"readonly>
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{$errors->first('avatar')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputDate">Ngày sinh</label>
                    <input type="date" class="form-control" id="exampleInputDate" placeholder="tên tác giả" name="date_birth" value="{{ old('date_birth') }}">
                    @if ($errors->has('date_birth'))
                        <span class="text-danger">{{$errors->first('date_birth')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Thông tin chi tiết</label>
                    <textarea type="text" class="form-control" id="exampleInputName" placeholder="Nhập thông tin chi tiết" name="description" value="{{ old('description') }}"></textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Thêm mới</button>
                    <a href="{{route('author.index')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
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