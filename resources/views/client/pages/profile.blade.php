@extends('client.pages.information')
@section('title','PolyLib')
@section('childCss')
<link rel="stylesheet" href="{{asset('css/client/pages/profile.css')}}">
@endsection
@section('body')
<div class="profile">

    <div class="profile-header">
        <h2 class="profile-header__h2">Thông tin tài khoản</h2>
    </div>
    <div class="profile-content">
        @if (session('message'))

        <div class="alert alert-success text-center alert-custom" role="alert">
            {{ session('message') }}
        </div>
        @endif
        <form action="{{route('infomation.edit',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-img__wrapper">
                <div class="profile-img-item">
                    <img src="{{asset(Auth::user()->avatar)}}" alt="">
                </div>
                <div class="profile-img-upload">
                    <input type="file" id="actual-btn" hidden name="avatar" />
                    <label for="actual-btn" id="actual-label">
                        <i class="fa fa-fw fa-camera"></i>
                        <span>Thay ảnh đại diện</span>
                    </label>

                    <span id="file-chosen">Chưa có file ảnh nào</span>

                </div>
            </div>

            <div class="profile-infomation ">

                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="profile-infomation__label">Họ và tên</label>
                            <input class="form-control" type="text" name="name" value="{{Auth::user()->name}}" placeholder="Vui lòng nhập tên của bạn">
                        </div>
                    </div>
                    <div class="col">

                        <div class="form-group">
                            <label class="profile-infomation__label">Email</label>
                            <input class="form-control" type="text" name="email" value="{{Auth::user()->email}}" placeholder="Vui lòng nhập email" readonly disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="profile-infomation__label">Số điện thoại</label>
                            <input class="form-control" type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="Vui lòng nhập số điện thoại">
                        </div>
                    </div>
                    <div class="col ">
                        <div class="form-group">
                            <label class="profile-infomation__label">Giới tính</label>
                            <div class="form-control ">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="man" value="0" @if (Auth::user()->gender == 0){{ "checked" }} @endif>
                                    <label class="form-check-label" for="man">Nam</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="woman" value="1" @if (Auth::user()->gender == 1){{ "checked" }} @endif>
                                    <label class="form-check-label" for="woman">Nữ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 ">
                        <div class="form-group">
                            <label class="profile-infomation__label">Ngày sinh</label>
                            <input class="form-control" type="date" name="birth_date" value="{{Auth::user()->birth_date}}" placeholder="Vui lòng nhập ngày sinh">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col d-flex justify-content-center">
                        <button class="btn profile-infomation__button " type="submit">Lưu lại</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    const actualBtn = document.getElementById('actual-btn');

    const fileChosen = document.getElementById('file-chosen');

    actualBtn.addEventListener('change', function() {
        fileChosen.textContent = this.files[0].name
    })
</script>
<!-- <div class="profile-info">
    <div class="row ho-so-ca-nhan">
        <div class="col-md-12 ho-so-ca-nhan">
            <h2>Hồ sơ cá nhân</h2>
        </div>
    </div>
    <form action="{{ route('infomation.edit',Auth::user()->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row infomation-form">
            <div class="col-md-6 infomation-form-profile">
                <table class="ws-table-all">
                    <tr>
                        <td><label class="profile-infomation__label" for=""> Họ và tên:</label></td>
                        <td><input type="text" name="email" value="{{Auth::user()->name}}"  readonly></td>
                    </tr>
                    <tr>
                        <td><label class="profile-infomation__label" for="">Email:</label></td>
                        <td><input type="email" name="email" value="{{Auth::user()->email}}"  readonly></td>
                    </tr>
                    <tr>
                        <td><label class="profile-infomation__label" for="">Số điện thoại:</label></td>
                        <td><input type="number" name="phone" value="{{Auth::user()->phone}}" ></td>
                    </tr>
                    <tr>
                        <td><label class="profile-infomation__label" for="">Ngày sinh:</label></td>
                        <td><input type="date" name="birth_date" value="{{Auth::user()->birth_date}}" ></td>
                    </tr>
                    <tr>
                        <td><label class="profile-infomation__label" for="">Giới tính</label></td>
                        <td>
                            <input type="radio" name="gender" value="1" @if (Auth::user()->gender == 1){{ "checked" }} @endif>
                            <label class="profile-infomation__label" for=""> Nam</label>
                            <input type="radio" name="gender" value="2" @if (Auth::user()->gender == 2){{ "checked" }} @endif>
                            <label class="profile-infomation__label" for=""> Nữ</label>
                            <input type="radio" name="gender" value="3" @if (Auth::user()->gender == 3){{ "checked" }} @endif>
                            <label class="profile-infomation__label" for=""> Giới tính khác</label>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 infomation-form-avatar">
                <div>
                    <label class="profile-infomation__label" for="">Ảnh đại diện</label>
                </div>
                <div>
                    {{--<input type="file" name="avatar">--}}
                    <img src="{{Auth::user()->avatar}}" name="image_avatar" alt="avatar">
                </div>
            </div>
            <div class="col-md-12 infomation-form-save">
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </div>
        </div>
    </form>
</div> -->
@endsection