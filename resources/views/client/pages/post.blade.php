@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/post.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')

<div class="container">
    <div class="row">

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
                            <a href="" class="post-user-name__link">
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
                                
                                <div class="post-wishlist">
                                    <span class="post-wishlist__span">

                                        <i class="fas fa-heart"></i>
                                        {{DB::table('wishlists')->where('post_id', $post->id)->count()}} Yêu thích
                                    </span>
                                </div>
                                <div class="post-view">
                                    <span class="post-view__span"><i class=" fa fa-eye"></i>
                                        9 lượt xem
                                    </span>
                                </div>
                                <div class="post-comment">
                                    <span class="post-comment__span"><i class=" fa fa-comments"></i>
                                        9 bình luận
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

                    <!-- <div class="post-aside__item">
                        <a href="" class="post-aside__link">
                            JavaScript
                        </a>
                    </div>
                    <div class="post-aside__item">
                        <a href="" class="post-aside__link">
                            Công nghệ thông tin
                        </a>
                    </div>
                    <div class="post-aside__item">
                        <a href="" class="post-aside__link">
                            React
                        </a>
                    </div>
                    <div class="post-aside__item">
                        <a href="" class="post-aside__link">
                            Xã hội và đời sống
                        </a>
                    </div>


                     -->
                </div>
            </div>
        </div>
    </div>
</div>





<!-- <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{ route('book.categories') }}" class="filter-item__link">
                            <li class="filter-item">
                                {{ __('Tất cả') }}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class=" filter-group ">
                    <h3 class="filter-heading">Danh mục</h3>
                    <ul class="filter-list ">

                        @foreach ($cates as $cate)
                        <a href="{{ route('book.category', $cate->slug) }}" class="filter-item__link">
                            <li class="filter-item">
                                {{ $cate->name }}
                                <span class="filter-item__quantity">{{ count($cate->posts) }}</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div> -->
<!-- <div class="post-item">
                    <div class="post-item__aside">
                        <div class="post-user-avatar">
                            <a href="" class="post-user-avatar__link">

                                <img class="post-user-avatar__img" class="post-user-avatar__img " src="https://res.cloudinary.com/practicaldev/image/fetch/s--IWtnt1Jv--/c_fill,f_auto,fl_progressive,h_90,q_auto,w_90/https://dev-to-uploads.s3.amazonaws.com/uploads/user/profile_image/679346/d557bea7-07c7-4c90-ad16-fcff94cc9f59.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="post-item__content">
                        <div class="post-user-name">
                            <a href="" class="post-user-name__link">
                                TAFF Inc | #WeMakeITHappen
                            </a>
                        </div>
                        <div class="post-content__date">Aug 20</div>
                        <div class="post-content__title">
                            <a href="" class="post-title__link">
                                10 Reasons Why Flutter is Setting the Trend in Mobile App Development in 2022
                            </a>
                        </div>
                        <div class="post-content__desc"></div>
                        <div class="post-content__tag">
                            <div class="post-tag__item">
                                <a href="" class="post-tag__link">
                                    #mobile
                                </a>
                            </div>
                            <div class="post-tag__item">
                                <a href="" class="post-tag__link">
                                    #mobile
                                </a>
                            </div>
                            <div class="post-tag__item">
                                <a href="" class="post-tag__link">
                                    #mobile
                                </a>
                            </div>
                            <div class="post-tag__item">
                                <a href="" class="post-tag__link">
                                    #mobile
                                </a>
                            </div>

                        </div>
                        <div class="post-content__footer">
                            <div class="post-footer__details">
                                <div class="post-view">
                                    <span class="post-view__span"><i class=" fa fa-eye"></i>
                                        9
                                    </span>
                                </div>
                                <div class="post-comment">
                                    <span class="post-comment__span"><i class=" fa fa-comments"></i>
                                        9
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

@endsection