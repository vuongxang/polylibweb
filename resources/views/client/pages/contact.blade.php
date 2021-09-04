@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/contact.css') }}">
@endsection

@section('title', 'PolyLib')
@section('content')

<div class="container">
    @if (session('message'))
        <div class="alert alert-success text-center">
            <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
        </div>
    @endif
    <!-- mobile -->
    <div class="contact-form__mobile">
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
        <div class=" col-md-8 contact-form__main ">
            <form action="{{route('contact')}}" method="post">
                @csrf
                <div class="row">
                    <div class="contact-form__topic">
                        @if ($errors->has('topic'))
                            <span class="text-danger">{{ $errors->first('topic') }}</span>
                        @endif
                        <input type="text" class="form-control" name="topic" placeholder="Chủ đề"  value="{{ old('topic') }}">
                        
                    </div>
                    <div class="contact-form__name">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" class="form-control" name="name" placeholder="Họ tên"  value="{{ old('name') }}">
                        
                    </div>
                    <div class="contact-form__email">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="email" class="form-control" name="email" placeholder="Email"  value="{{ old('email') }}">
                        
                    </div>
                    <div class="contact-form__phone">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                        <input type="number" class="form-control" name="phone" placeholder="Số điện thoại"  value="{{ old('phone') }}">
                        
                    </div>
                    <div class="contact-form__content">
                        @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                        @endif
                        <textarea class="form-control" name="content" cols="31" rows="10" placeholder="Nội dung">{{ old('content') }}</textarea>
                        
                    </div>
                    <div class="contact-form__button">
                        <button type="submit" class="btn btn-primary">Gửi</button>
                    </div>
                </div>
            </form>
        </div>
      
    </div>
     <!-- desktop -->
    <div class="contact-form__desktop">
        <div class="contact-form__main col-md-8">
            <form action="{{route('contact')}}" method="post">
                @csrf
                <div class="row">
                    <div class="contact-form__topic">
                        @if ($errors->has('topic'))
                            <span class="text-danger">{{ $errors->first('topic') }}</span>
                        @endif
                        <input type="text" class="form-control" name="topic" placeholder="Chủ đề"  value="{{ old('topic') }}">
                        
                    </div>
                    <div class="contact-form__name">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                        <input type="text" class="form-control" name="name" placeholder="Họ tên"  value="{{ old('name') }}">
                        
                    </div>
                    <div class="contact-form__email">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                        <input type="email" class="form-control" name="email" placeholder="Email"  value="{{ old('email') }}">
                        
                    </div>
                    <div class="contact-form__phone">
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                        <input type="number" class="form-control" name="phone" placeholder="Số điện thoại"  value="{{ old('phone') }}">
                        
                    </div>
                    <div class="contact-form__content">
                        @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                        @endif
                        <textarea class="form-control" name="content" cols="31" rows="10" placeholder="Nội dung">{{ old('content') }}</textarea>
                        
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