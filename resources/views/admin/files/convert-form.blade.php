@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h3 class="m-0 font-weight-bold h6 text-primary">Convert PDF file to JPG file</h3>
    </div>
    <div class="row">
        @if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
        @endif
        <div class="col-sm-12 col-md-8 offset-2">
          
            <form action="{{route('file.convertStore')}}" method="post" enctype="multipart/form-data" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label class="text-dark font-weight-bold">Nhập file PDF</label>
                    {{-- <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
                        Chọn file
                    </button>
                    <input type="text" id="file" name="file" class="form-control"> --}}
                    <input type="file" name="pdf_file" id="" class="form-controll">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{$errors->first('pdf_file')}}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Thực hiện</button>
                    <a href="{{route('filemanager')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
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
          {{-- <button type="button" class="btn btn-primary btn-sm">Lưu</button> --}}
        </div>
      </div>
    </div>
  </div>
@endsection