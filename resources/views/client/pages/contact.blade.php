@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/contact.css') }}">
@endsection

@section('content')



<div class="container">
    <div class=" profile-info">
        <div class="row ho-so-ca-nhan">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Liên hệ</h2>
            </div>
        </div>
        @if (session('message'))
        <div class="alert alert-success text-center">
            <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
        </div>
        @endif
    </div>
    <div class="contact-form">
        <form action="{{route('contact')}}" method="post">
            @csrf
            <div class="contact-form__name">
                <label for="">Chủ đề</label>
                <input type="text" class="form-control" name="topic">
            </div>
            <div class="contact-form__name">
                <label for="">Tên</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="contact-form_email">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="contact-form__phone">
                <label for="">Số điện thoại</label>
                <input type="number" class="form-control" name="phone">
            </div>
            <div class="contact-form__note">
                <label for="">Ý kiến</label>
                <textarea class="form-control" name="content" cols="30" rows="5"></textarea>
            </div>
            <div class="contact-form__button">
                <button type="submit" class="btn btn-primary">Gủi</button>
            </div>
        </form>
    </div>
</div>
@endsection