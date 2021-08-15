@extends('admin.layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold h6 text-primary">Convert PDF file to JPG file</h3>
        </div>
        <div class="row">
            @if (Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <div class="col-sm-12 col-md-8 offset-2">

                <form action="" method="post" id="fileUploadForm" enctype="multipart/form-data"
                    class="mt-4 mb-4">
                    @csrf
                    <div class="form-group">
                        <label class="text-dark font-weight-bold">Nhập file PDF</label>
                        {{-- <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
                        Chọn file
                    </button>
                    <input type="text" id="file" name="file" class="form-control"> --}}
                        <input type="file" name="pdf_file" id="pdf_file" class="form-controll">
                        @if ($errors->has('image'))
                            <span class="text-danger">{{ $errors->first('pdf_file') }}</span>
                        @endif
                    </div>
                    <div class="text-center">
                        <input type="submit" name="save" id="save" class="btn btn-dark btn-sm shadow-lg" value="Thực hiện" />
                        <a href="{{ route('filemanager') }}" class="btn btn-danger btn-sm shadow">Hủy</a>
                    </div>
                </form>
                <div class="form-group" id="process">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" style="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
