@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{asset('css/client/pages/information.css')}}">
@yield('childCss')
@endsection

@section('title', 'PolyLib')
@section('content')




<div class="container">
    <div class="row">
        <div class="col-md-3 ">
            
            <div class="information-aside">
                <ul class="information-aside__list ">
                    <li class="information-aside__header ">
                        Thông tin tài khoản
                    </li>
                    <li class="information-aside__item">
                        <a href="{{route('client.profile',Auth::user()->id)}}" class="{{ (request()->is('profile*')) ? 'active' : '' }}  information-aside__link">Hồ sơ cá nhân</a>
                    </li>
                    <li class="information-aside__item">
                        <a href="{{route('notifications')}}" class="{{ (request()->is('notifications')) ? 'active' : '' }} information-aside__link">Thông báo</a>
                    </li>
                    
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            @yield('body')
        </div>

    </div>

</div>

@endsection