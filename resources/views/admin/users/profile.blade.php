@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Hồ sơ cá nhân</h6>
    </div>
    <div class="card-body">
        <div class="profile-info">
            @if (Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                    {{ Session::get('message') }}</p>
            @endif
            <form action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row infomation-form">
                    <div class="col-md-6 infomation-form-profile">
                        <table class="ws-table-all">
                            <tr>
                                <td><label for=""> Họ và tên:</label></td>
                                <td><input type="text" name="email" value="{{Auth::user()->name}}" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><label for="">Email:</label></td>
                                <td><input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" readonly></td>
                            </tr>
                            <tr>
                                <td><label for="">Số điện thoại:</label></td>
                                <td><input type="number" name="phone" value="{{Auth::user()->phone}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="">Ngày sinh:</label></td>
                                <td><input type="date" name="birth_date" value="{{Auth::user()->birth_date}}" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="">Giới tính</label></td>
                                <td>
                                    <input type="radio" name="gender" value="1" @if (Auth::user()->gender == 1){{ "checked" }} @endif>
                                    <label for=""> Nam</label>
                                    <input type="radio" name="gender" value="2" @if (Auth::user()->gender == 2){{ "checked" }} @endif>
                                    <label for=""> Nữ</label>
                                    <input type="radio" name="gender" value="3" @if (Auth::user()->gender == 3){{ "checked" }} @endif>
                                    <label for=""> Giới tính khác</label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 infomation-form-avatar">
                        <div>
                            <label for="">Ảnh đại diện</label>
                        </div>
                        <div>
                            {{--<input type="file" name="avatar">--}}
                            <img src="{{Auth::user()->avatar}}" name="image_avatar" alt="avatar" style="width: 400px; height:auto; object-fit: cover">
                        </div>
                    </div>
                    <div class="col-md-12 infomation-form-save">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection