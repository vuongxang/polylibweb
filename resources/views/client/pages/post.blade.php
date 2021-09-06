@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/post.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')

<div class="container">
    <div class="row post-mobile">
        <div class="col-md-3 post-aside">
            <div class="post-aside-wrap">
                <div id="row_wishlist"></div>
                <div class="post-aside-header cate-post">
                    <div class="post-aside-header__text">Danh mục bài viết</div>

                </div>
                <div class="post-aside__list show-cate-post">
                    @foreach ($cates as $cate)
                    <div class="post-aside__item">
                        <a href="{{ route('post.category', $cate->slug) }}" class="post-aside__link">
                            {{ $cate->name }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-9 post-wrap">
            <div class="post-header">
                <div class="post-header-text">Danh sách bài viết</div>
                <div class="post-header-button">
                    <a href="{{route('post.create')}}" class="post-header-link">Tạo bài viết</a>
                </div>
            </div>
            @if(!empty($message))
            <div class="search-result">
                <div class="search-text">
                    {{ $message }}
                </div>
            </div>
            @endif<div class="post-list">
                @foreach ($posts as $post)
                <div class="post-item">
                    <div class="post-item__aside">
                        <div class="post-user-avatar">
                            <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}" class="post-user-avatar__link">

                                <img class="post-user-avatar__img" class="post-user-avatar__img " src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="post-item__content">

                        <div class="post-user-name">
                            <a href="{{ route('post.user', $post->user()->withTrashed()->first()->id )}}" class="post-user-name__link">
                                {{ $post->user()->withTrashed()->first()->name }}
                            </a>
                        </div>
                        <div class="post-content__title">
                            <a href="{{ route('post.detail', $post->slug) }}" class="post-title__link">
                                {{ $post->title }}
                            </a>
                        </div>

                        <!-- <div class="post-content__desc">{!! $post->content !!}</div> -->

                        <div class="post-content__tag">
                            @foreach($post->cates as $cate)
                            <div class="post-tag__item">
                                <a href="{{ route('post.category', $cate->slug) }}" class="post-tag__link">
                                    #{{$cate->name}}
                                </a>
                            </div>
                            @endforeach


                        </div>
                        <div class="post-content__footer">
                            <div class="post-footer__details">
                                <div class="post-content__date">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</div>

                                <div class="post-wishlist">
                                    <span class="post-wishlist__span">

                                        <i class="fas fa-heart"></i>
                                        {{DB::table('wishlists')->where('post_id', $post->id)->count()}} Yêu thích
                                    </span>
                                </div>
                                <div class="post-view">
                                    <span class="post-view__span"><i class=" fa fa-eye"></i>
                                        {{$post->postViews()->sum('views')}}
                                        lượt xem
                                    </span>
                                </div>
                                <div class="post-comment">
                                    <span class="post-comment__span"><i class=" fa fa-comments"></i>
                                        {{count($post->comments)}} bình luận
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
            <div class="text-center">
                {{ $posts->links('vendor.pagination.post-pagination') }}
            </div>
        </div>

    </div>
    <div class="row post-desktop">
        <div class="col-md-9 post-wrap">
            <div class="post-header">
                <div class="post-header-text">Danh sách bài viết</div>
                <div class="post-header-button">
                    <a href="{{route('post.create')}}" class="post-header-link">Tạo bài viết</a>
                </div>
            </div>
            @if(!empty($message))
            <div class="search-result">
                <div class="search-text">
                    {{ $message }}
                </div>
            </div>
            @endif<div class="post-list">
                @foreach ($posts as $post)
                <div class="post-item">
                    <div class="post-item__aside">
                        <div class="post-user-avatar">
                            <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}" class="post-user-avatar__link">

                                <img class="post-user-avatar__img" class="post-user-avatar__img " src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="post-item__content">

                        <div class="post-user-name">
                            <a href="{{ route('post.user', $post->user()->withTrashed()->first()->id )}}" class="post-user-name__link">
                                {{ $post->user()->withTrashed()->first()->name }}
                            </a>
                        </div>
                        <div class="post-content__title">
                            <a href="{{ route('post.detail', $post->slug) }}" class="post-title__link">
                                {{ $post->title }}
                            </a>
                        </div>

                        <!-- <div class="post-content__desc">{!! $post->content !!}</div> -->

                        <div class="post-content__tag">
                            @foreach($post->cates as $cate)
                            <div class="post-tag__item">
                                <a href="{{ route('post.category', $cate->slug) }}" class="post-tag__link">
                                    #{{$cate->name}}
                                </a>
                            </div>
                            @endforeach


                        </div>
                        <div class="post-content__footer">
                            <div class="post-footer__details">
                                <div class="post-content__date">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</div>

                                <div class="post-wishlist">
                                    <span class="post-wishlist__span">

                                        <i class="fas fa-heart"></i>
                                        {{DB::table('wishlists')->where('post_id', $post->id)->count()}} Yêu thích
                                    </span>
                                </div>
                                <div class="post-view">
                                    <span class="post-view__span"><i class=" fa fa-eye"></i>
                                        {{$post->postViews()->sum('views')}}
                                        lượt xem
                                    </span>
                                </div>
                                <div class="post-comment">
                                    <span class="post-comment__span"><i class=" fa fa-comments"></i>
                                        {{count($post->comments)}} bình luận
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach


            </div>
            <div class="text-center">
                {{ $posts->links('vendor.pagination.post-pagination') }}
            </div>
        </div>
        <div class="col-md-3 post-aside">
            <div class="post-aside-wrap">
                <div id="row_wishlist"></div>
                <div class="post-aside-header">
                    <div class="post-aside-header__text">Danh mục bài viết</div>

                </div>
                <div class="post-aside__list ">
                    @foreach ($cates as $cate)
                    <div class="post-aside__item">
                        <a href="{{ route('post.category', $cate->slug) }}" class="post-aside__link">
                            {{ $cate->name }} 
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.cate-post').click(function() {
            $('.post-aside-header').toggleClass('show-border')

            $('.post-aside__list').slideToggle();
        })
    })
</script>


@endsection