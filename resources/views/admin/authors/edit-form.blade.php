@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cập nhật thông tin tác giả</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-2">
            <form action="{{route('author.update',$model->id)}}" method="post" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Tên tác giả</label><br>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Tên tác giả" name="name" value="{{ old('name',$model->name) }}">
                    
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Ảnh đại diện</label>
                    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">
                        Chọn ảnh
                    </button><br>
                    @if ($errors->has('avatar'))
                        <span class="text-danger">{{$errors->first('avatar')}}</span>
                    @endif
                    <div class="show_image" class="mb-2">
                        <img src="{{ old('avatar',$model->avatar) }}" alt="" id="show_img" width="200">
                    </div>
                    <input type="text" id="image" hidden name="avatar" class="form-control" value="{{old('avatar',$model->avatar)}}">
                    
                </div>
                <div class="form-group">
                    <label for="exampleInputDate">Ngày sinh</label><br>
                    @if ($errors->has('date_birth'))
                        <span class="text-danger">{{$errors->first('date_birth')}}</span>
                    @endif
                    <input type="date" class="form-control" id="exampleInputDate" placeholder="" name="date_birth" value="{{ old('date_birth',$model->date_birth) }}">
                    
                </div>
                <div class="form-group">
                    <label for="exampleInputDesc">Thông tin chi tiết</label><br>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                    <textarea type="text" class="form-control" rows="15" id="exampleInputDesc" placeholder="Nhập thông tin chi tiết" name="description">{!!old('description',$model->description)!!}</textarea>
                    
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark rounded-pill shadow-lg">LƯU</button>
                    <a href="{{route('author.index')}}" class="btn btn-danger rounded-pill shadow">HỦY</a>
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