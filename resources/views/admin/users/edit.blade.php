@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cập nhật tài khoản</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Sửa thông tin</div>
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
                            @endif
                            <div class="card-body">
                                <form method="POST" action="">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name',$user->name)}}" autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            
                                        <div class="col-md-6">
                                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}" autocomplete="email" autofocus readonly>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Vai trò') }}</label>
                                        <div class="col-md-6">
                                            <select name="role_id" class="form-control">
                                                @foreach ($roles as $role)
                                                    <option value="{{$role->id}}"
                                                        @if ($role->id==$user->role_id)
                                                            selected
                                                        @endif
                                                        >{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Giới tính') }}</label>
            
                                        <div class="col-md-6">
                                            <div class="form-control ">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="man" value="0" @if ($user->gender == 0){{ "checked" }} @endif>
                                                    <label class="form-check-label" for="man">Nam</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="gender" id="woman" value="1" @if ($user->gender == 1){{ "checked" }} @endif>
                                                    <label class="form-check-label" for="woman">Nữ</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="birth-date-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Ngày sinh') }}</label>
            
                                        <div class="col-md-6">
                                            <input class="form-control" id="birth-date-confirm" type="date" name="birth_date" value="{{$user->birth_date}}" placeholder="Vui lòng nhập ngày sinh">
                                        </div>
                                    </div>
                                    <input class="form-control" type="hidden" name="password" value="{{$user->password}}">
                                    <input class="form-control" type="hidden" name="password_confirmation" value="{{$user->password}}">
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