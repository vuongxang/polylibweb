@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/contact.css') }}">
@endsection

@section('content')



<div class="container">
    @if (session('message'))
        <div class="alert alert-success text-center">
            <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
        </div>
    @endif
    <div class="contact-form">
        <!-- <div class="contact-demo" style="background-image:url('images/contact.png');">
            <div class="contact-demo-1"></div>
            <div class="contact-demo-2"></div>
        </div> -->
        
        <div class="contact-form__main col-md-8">
            <form action="{{route('contact')}}" method="post">
                @csrf
                <div class="row">
                    <div class="contact-form__topic">
                        <input type="text" class="form-control" name="topic" placeholder="Chủ đề"  value="{{ old('topic') }}" required>
                        @if ($errors->has('topic'))
                            <span class="text-danger">{{ $errors->first('topic') }}</span>
                        @endif
                    </div>
                    <div class="contact-form__name">
                        <input type="text" class="form-control" name="name" placeholder="Họ tên"  value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="contact-form__email">
                        <input type="email" class="form-control" name="email" placeholder="Email"  value="{{ old('email') }}" >
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="contact-form__phone">
                        <input type="number" class="form-control" name="phone" placeholder="Số điện thoại"  value="{{ old('phone') }}" required>
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="contact-form__content">
                        <textarea class="form-control" name="content" cols="31" rows="10" placeholder="Nội dung" required>{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                    <div class="contact-form__button">
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 contact-form__profile">
            <div class="contact-form__profile__header">
                <strong>Thông tin liên hệ</strong>
            </div>
            <div class="form-contact__profile__content">
                <div class="contact-address">
                    <p>
                        <i class="fa fa-map-marked-alt"></i>
                        Khu E, Tòa nhà FPT Polytechnic, đường Trịnh Văn Bô, Phương Canh, Nam Từ Liêm, Hà Nội
                    </p> 
                </div>
                <div class="contact-email">
                    <p>
                        <i class="fa fa-envelope"></i>
                        polylib@fpt.edu.vn
                    </p> 
                </div>
                <div class="contact-phone">
                    <p>
                        <i class="fa fa-phone-alt"></i>
                        (024) 8582 0808
                    </p> 
                </div>
                <div class="contact-email">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection