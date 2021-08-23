@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/category.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">
        
        <div class="col-md-9 book-category__content">
            <span>Đăng lúc {{$post->created_at}}</span> <span id="viewNumber">Lượt xem: {{$totalViews}}</span>
            <h2>Tiêu đề: {{$post->title}}</h2>
            <img src="{{asset($post->thumbnail)}}" alt="" width="100%">
            <div>
                Nội dung: 
                {!!$post->content!!}
            </div>
            <div>
                @if ($post->postFiles)
                    show post file here
                @endif
            </div>
        </div>
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <div class=" filter-group ">
                    <ul class="filter-list ">
                        <a href="{{route('book.categories')}}" class="filter-item__link">
                            <li class="filter-item">
                                {{__('Tất cả')}}
                            </li>
                        </a>

                    </ul>
                </div>
                <div class=" filter-group ">
                    <h3 class="filter-heading">Danh mục</h3>
                    <ul class="filter-list ">

                        @foreach($cates as $cate)
                        <a href="{{route('book.category',$cate->slug)}}" class="filter-item__link">
                            <li class="filter-item">
                                {{$cate->name}}
                                <span class="filter-item__quantity">{{count($cate->posts)}}</span>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script>
    //Tang view sau 2s
    let increaseViewUrl = "{{ route('post.updateView') }}";
            const data = {
                id: {{ $post->id }},
                _token: "{{ csrf_token() }}"
            };
            setTimeout(() => {
                document.querySelector('#viewNumber').innerText = "Lượt xem :" + "{{ $totalViews + 1 }}";
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
                    })
            }, 2000);
</script>