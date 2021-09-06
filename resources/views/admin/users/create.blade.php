@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm mới tài khoản</h6>
    </div>
    <div class="card-body ">
        <div class="table-responsive">
            <div class="container">
                <div class="row flex-lg-nowrap ">
                    <div class="col mb-3 ">


                        @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
                        @endif
                        <form action="" class="form" method="post" enctype="multipart/form-data">
                            <div class="tab-content pt-2">
                                <div class="tab-pane active">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="name">Họ và tên</label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Vui lòng nhập tên của bạn">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Vui lòng nhập email">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="password" class="">{{ __('Mật khẩu') }}</label>

                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Vui lòng nhập mật khẩu">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label for="password-confirm" class="">{{ __('Xác nhận mật khẩu') }}</label>

                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password" placeholder="Vui lòng nhập lại mật khẩu">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col d-flex justify-content-center">
                                    <button class="btn btn-primary btn-sm" type="submit">Lưu lại</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>

















            </div>
        </div>
    </div>
</div>


@endsection