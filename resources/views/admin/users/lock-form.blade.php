@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Khóa tài khoản</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Form</div>
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
                            @endif
                            <div class="card-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="file_upload" class="col-md-4 col-form-label text-md-right">{{ __('Upload File') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="file_upload" type="file" class="form-control @error('file_upload') is-invalid @enderror" name="file_upload" value="{{ old('file_upload') }}" autocomplete="file_upload" autofocus>
                                            @error('file_upload')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Lưu') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection