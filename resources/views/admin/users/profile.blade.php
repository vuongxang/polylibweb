@extends('admin.layouts.main')
@section('content')
<div class="row flex-lg-nowrap ">
    <div class="col mb-3 ">
        <div class="card rounded border-0 shadow">
            <div class="card-body">
                <div class="e-profile">
                    <div class="row">
                        <div class="col-12 col-sm-auto mb-3">
                            <div class="mx-auto" style="width: 140px;height: 140px">
                                <img src="{{Auth::user()->avatar}}" alt="" class=" d-flex justify-content-center align-items-center rounded" style="width:100%">
                            </div>
                        </div>
                        <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                            <div class="text-center text-sm-left mb-2 mb-sm-0">
                                <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{Auth::user()->name}}</h4>
                                <p class="mb-0">{{Auth::user()->email}}</p>
                                <!-- <div class="text-muted"><small>Last seen 2 hours ago</small></div> -->
                                <!-- <div class="mt-2">
                                            <button class="btn btn-primary btn-sm" type="button">
                                                <i class="fa fa-fw fa-camera"></i>
                                                <span>Change Photo</span>
                                            </button>
                                        </div> -->
                            </div>
                            <div class="text-center text-sm-right">
                                <span class="badge badge-secondary">{{Auth::user()->role->name}}</span>
                                <div class="text-muted"><small>Ngày tạo: {{Carbon\Carbon::parse(Auth::user()->created_at)->format('d/m/Y')}}</small></div>
                            </div>
                        </div>
                    </div>
                    @if(Session::has('message'))
                    <p class="alert alert-success text-center">{{ Session::get('message') }}</p>
                    @endif
                    <form action="{{route('user.profile',Auth::user()->id)}}" class="form" method="post" enctype="multipart/form-data">
                        <div class="tab-content pt-2">
                            <div class="tab-pane active">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Họ và tên</label>
                                            <input class="form-control" type="text" name="name" value="{{Auth::user()->name}}" placeholder="Vui lòng nhập tên của bạn">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Số điện thoại</label>
                                            <input class="form-control" type="text" name="phone" value="{{Auth::user()->phone}}" placeholder="Vui lòng nhập số điện thoại">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input class="form-control" type="text" name="email" value="{{Auth::user()->email}}" placeholder="Vui lòng nhập email" readonly disabled>
                                        </div>
                                    </div>
                                    <div class="col ">
                                        <div class="form-group">
                                            <label>Giới tính</label>
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
                                    <div class="col ">
                                        <div class="form-group">
                                            <label>Ngày sinh</label>
                                            <input class="form-control" type="date" name="birth_date" value="{{Auth::user()->birth_date}}" placeholder="Vui lòng nhập ngày sinh">
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








@endsection