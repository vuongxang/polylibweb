@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/infomation.css')}}">
@endsection

@section('content')


@if (session('message'))
    <div class="alert alert-success text-center">
        <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
    </div>
@endif

<div class="container">
    <div class="profile-info">
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
                        <img src="{{Auth::user()->avatar}}" name="image_avatar" alt="avatar">
                    </div>
                </div>
                <div class="col-md-12 infomation-form-save">
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection