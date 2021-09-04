@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/post-user.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="user-info-wrap">
                <div class="user-info__avatar">
                    <img src="{{asset($user->avatar)}}" alt="">

                </div>
                <div class="user-info__name">
                    {{$user->name}}
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="user-info__aside">
                        <div class="user-info-aside__list">
                            <div class="user-info__aside__item">
                                <div class="user-info__aside__icon">
                                    <i class="fas fa-poll"></i>
                                </div>
                                <div class="user-info__aside__text">{{$posts->total()}} bài viết</div>
                            </div>
                            <div class="user-info__aside__item">
                                <div class="user-info__aside__icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="user-info__aside__text">{{count($user->wishlist)}} bài viết yêu thích</div>
                            </div>
                            {{-- <div class="user-info__aside__item">
                                <div class="user-info__aside__icon">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="user-info__aside__text">9 bài viết đã bình luận</div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="post-list">
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
                                    <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}" class="post-user-name__link">
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
                                        <a href="" class="post-tag__link">
                                            #{{$cate->name}}
                                        </a>
                                    </div>
                                    @endforeach


                                </div>
                                <div class="post-content__footer">
                                    <div class="post-footer__details">
                                        <div class="post-content__date">{{ Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</div>
                                        <div class="post-view">
                                            <span class="post-view__span"><i class=" fa fa-eye"></i>
                                                {{$post->postViews()->sum('views')}} lượt xem
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
        </div>

    </div>
</div>




@endsection