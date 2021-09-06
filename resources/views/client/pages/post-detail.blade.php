@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/post-detail.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 post-detail__content">
            <div class="post-detail__wrap">
                <div class="post-detail__cover">
                    <img src="{{asset($post->thumbnail)}}" alt="">
                </div>
                <div class="post-detail__body">
                    <div class="post-body__header">
                        {{$post->title}}

                    </div>



                    <div class="post-body-user__wrap">
                        <div class="post-body__user">
                            <div class="post-body-user__avatar">
                                <img src="{{asset($post->user()->withTrashed()->first()->avatar)}}" alt="">
                            </div>
                            <div class="post-body-user__name">
                                <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}" class="post-body-user__link">
                                    {{$post->user()->withTrashed()->first()->name}}

                                </a>
                                <div class="post-body-created">
                                    {{ $post->created_at->diffforhumans()}}
                                </div>
                            </div>

                        </div>
                        <div class="post-body-react">
                            <div class="post-view">
                                <i class="fas fa-eye"></i> <span id="viewNumber">{{$totalViews}}</span>
                            </div>
                            <div class="post-wishlist">

                                @if($wishlist)
                                <a class="fill-heart" href="{{route('post.wishlist.destroy',['id'=>$post->id])}}">
                                    <img src="{{ asset('images/heart-icon-fa.svg') }}" alt="">
                                </a>
                                @else
                                <a href="{{route('post.wishlist',['id'=>$post->id])}}" id="{{$post->id}}">
                                    <img src="{{ asset('images/heart-icon-far.svg') }}" alt="">
                                </a>
                                @endif
                            </div>
                        </div>

                    </div>

                    @if(count($post->cates)>0)
                    <div class="post-body__cates">
                        @foreach($post->cates as $cate)
                        <div class="post-cate__item">
                            <a href="{{route('post.category',$cate->slug)}}" class="post-cate__link">
                                #{{$cate->name}}
                            </a>
                        </div>
                        @endforeach
                        <!-- <div class="post-cate__item">
                            <a href="" class="post-cate__link">
                                #career
                            </a>
                        </div>
                        <div class="post-cate__item">
                            <a href="" class="post-cate__link">
                                #codenewbie
                            </a>
                        </div>
                        <div class="post-cate__item">
                            <a href="" class="post-cate__link">
                                #beginners
                            </a>
                        </div> -->
                    </div>
                    @endif
                    <div class="post-body__content">

                        {!! $post->content !!}

                    </div>

                </div>
                @if(count($post->postFiles)> 0)
                <div class="post-detail-attachment">
                    <div class="post-comment__header">
                        <div class="post-comment__text">
                            Tệp đính kèm
                        </div>
                    </div>
                    <div class="post-attachment__body" >

                        <div id="post-attachment__wrap">
                            @foreach($post->postFiles as $file)
                            <div>
                                <a href="{{asset($file->url)}}" target="_blank">{{$file->title}}</a>
                            </div>
                            @endforeach
                        </div>



                    </div>
                </div>
                @endif
                <div class="post-detail__comment">
                    <div class="post-comment__header">
                        <div class="post-comment__text">
                            Bình luận
                        </div>
                    </div>
                    @include('client.blocks.postCommentsDisplay', ['comments' => $comments, 'post' => $post->id])
                    <div class="comment-box__wrapper">
                        <div class="comment-box__image">
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="" id="js-user-avatar">
                        </div>
                        <div class="comment-box__content">
                            <form action="{{ route('postComments.store') }}" method="post">
                                @csrf
                                <div class="comment__input">
                                    <textarea class="form-control" name="body" rows="2" placeholder="Viết bình luận..."></textarea>
                                    <input type="hidden" name="post_id" value="{{$post->id}}" />
                                </div>
                                <div class="comment__btn">
                                    <button type="submit" class="button button__background-lg button-comment">Bình
                                        luận</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 post-detail__aside">
            <div class="post-aside__user">
                <div class="post-user__avatar">
                    <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}">
                        <img class="post-user__img" src="{{asset($post->user()->withTrashed()->first()->avatar)}}" alt="">
                    </a>
                </div>

                <div class="posts-of-user">
                    <div class="posts-of-user__header">
                        Bài viết khác của <a href="{{route('post.user',$post->user()->withTrashed()->first()->id)}}" class="post-user__link">
                            {{$post->user()->withTrashed()->first()->name}}
                        </a>
                    </div>
                    <div class="posts-of-user__list">

                        @foreach($postsOfUser as $postOfUser)
                        <div class="posts-of-user__item">
                            <a href="{{route('post.detail',$postOfUser->slug)}}" class="posts-of-user__link">
                                <div class="posts-of-user__title">

                                    {{$postOfUser->title}}

                                </div>
                                @if(count($postOfUser->cates)>0)
                                <div class="posts-of-user__tag">
                                    @foreach($postOfUser->cates as $catePostUser)
                                    <div class="post-tag__item">

                                        #{{$catePostUser->name}}
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </a>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //Tang view sau 10s
    let increaseViewUrl = "{{ route('post.updateView') }}";
    const data = {
        id: {{ $post->id }},
        _token: "{{ csrf_token() }}"
    };
    setTimeout(() => {
        fetch(increaseViewUrl, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(responseData => responseData.json())
            .then(postObj => {
                console.log(postObj);
                document.querySelector('#viewNumber').innerText = "{{ $totalViews + 1 }}";

            })
    }, 10000);
</script>
@endsection
<!-- <div class="col-md-9 post-detail__content">
    <div class="post-detail__wrap">
        <div class="post-detail__cover">
            <img src="https://res.cloudinary.com/practicaldev/image/fetch/s--g0FMofbc--/c_imagga_scale,f_auto,fl_progressive,h_420,q_auto,w_1000/https://dev-to-uploads.s3.amazonaws.com/uploads/articles/qnsc6vogivvgyjcemki6.jpg" alt="">
        </div>
        <div class="post-detail__body">
            <div class="post-body__header">
                I Bet You Don't Keep A Developer Journal: 3 Reasons You Should
            </div>
            <div class="post-body__cates">
                <div class="post-cate__item">
                    <a href="" class="post-cate__link">
                        #web-dev
                    </a>
                </div>
                <div class="post-cate__item">
                    <a href="" class="post-cate__link">
                        #career
                    </a>
                </div>
                <div class="post-cate__item">
                    <a href="" class="post-cate__link">
                        #codenewbie
                    </a>
                </div>
                <div class="post-cate__item">
                    <a href="" class="post-cate__link">
                        #beginners
                    </a>
                </div>
            </div>
            <div class="post-body__user">
                <div class="post-body-user__avatar">
                    <img src="https://res.cloudinary.com/practicaldev/image/fetch/s--Bs915oY_--/c_fill,f_auto,fl_progressive,h_50,q_auto,w_50/https://dev-to-uploads.s3.amazonaws.com/uploads/user/profile_image/660288/3a653bcc-4ee3-49f3-a036-94d6560d588f.png" alt="">
                </div>
                <div class="post-body-user__name">
                    <a href="" class="post-body-user__link">
                        Simon Barker
                    </a>
                    <div class="post-body-created">
                        26 thg 8
                    </div>
                </div>

            </div>
            <div class="post-body__content">
                <p>"Do you know how to get rid of this weird primodials issue?" I was asked across the office once.</p>

                <p>Something about it sounded familiar so I did a quick search through my work journal and sure enough unearthed a note from 3 months earlier where I had seen this issue myself and jotted down the solution.</p>

                <p>"You're running the wrong node version for that application" I confidently reply.</p>

                <p>I looked like a super hero for remembering, when in fact all I did was look back through my external store of knowledge where I jot things down every day and regurgitate it. It helped in this case that the issue had a cool name in it (which is why I use this as my main example) but if it was something I had come across in my career, pretty much any relevant search term would work.</p>

                <p>The value in keeping a work journal is huge, here's why.</p>

                <h2>
                    <a name="its-not-for-you-to-read" href="#its-not-for-you-to-read">
                    </a>
                    It's not for you to read
                </h2>

                <p>It's tempting to think that a journal is for you to go back and read. In reality it's not, it's a searchable store of knowledge where one of the pieces of information is the date it happened on. Don't worry about making it interesting to read or feel like a story, it's a series of notes, events, error messages and solutions from your day that could be useful in the future.</p>

                <h2>
                    <a name="its-a-database" href="#its-a-database">
                    </a>
                    It's a database
                </h2>

                <p>It's really a database, a loosely structured, highly searchable database that enables the value of your developer experience to compound over time. The more you put into it the more valuable it becomes because of how bad our memories are. Each nugget of information makes connections to other morsels of information highlighting links you may have missed. Searching for <code>.htaccess</code> in my database brings up rewrite rules for old projects, reminds me of old projects I had forgotten about and highlights bits of tangential information that can unearth memories, like the terror of ftp'ing on to a live server and hot fixing a PHP bug without a <code>git commit</code> or line of yaml insight, good times!</p>

                <h2>
                    <a name="it-gives-you-confidence" href="#it-gives-you-confidence">
                    </a>
                    It gives you confidence
                </h2>

                <p>We often forget how far we have come, we focus on our current point in space and time, rather than the line and trajectory we are on. Having a store of knowledge, no matter how disorganised and seemingly disparate, lets us see how far we have come, how many problems we have solved and struggles we have overcome.</p>

                <p>As digital creators much of our work is invisible 🙁 </p>

                <p>When my wife sees a car from particularly high end sports car company drive past she is reminded of the work she put into that car's development, when my friend drives over certain bridges he can see the physical manifestation of his work. </p>

                <p>I on the other hand don't see the database migrations or api rewrite that took months of my time at my first job. I can, however look at my journal and see the things I learned, techniques I mastered and best practices I applied during that work because I noted it all down.</p>

                <h2>
                    <a name="anything-will-do" href="#anything-will-do">
                    </a>
                    Anything will do
                </h2>

                <p>Don't sweat the tool you use, text files work if you have a good way to search them. <a href="http://notion.so">Notion</a> is my favourite app of choice at the moment. <a href="http://evernote.com">Evernote</a> was all the rage for a few years there and no <a href="http://obsidian.md">Obsidian</a> is the new kind in town. So long as it's quick to jot something down, has good search and doesn't get in your way then it's good enough to get going with!</p>

                <p>So, go forth and journal!</p>

            </div>

        </div>
        <div class="post-detail__comment">
            <div class="post-comment__header">
                <div class="post-comment__text">
                    Bình luận
                </div>
            </div>
            <div class="comment-box__wrapper">
                <div class="comment-box__image">
                    {{-- <img src="{{ asset(Auth::user()->avatar) }}" alt="" id="js-user-avatar">
                </div>
                <div class="comment-box__content">
                    <form action="{{ route('comments.store') }}" method="post">
                        @csrf --}}
                        <div class="comment__input">
                            <textarea class="form-control" name="body" rows="2" placeholder="Viết bình luận..."></textarea>
                            <input type="hidden" name="book_id" value="" />
                        </div>
                        <div class="comment__btn">
                            <button type="submit" class="button button__background-lg button-comment">Bình
                                luận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@section('script')

<script src="{{asset('js/client/post-detail.js')}}"></script>

@endsection