@extends('client.layouts.index')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/client/pages/category.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-9 book-category__content">
            <div>
                <ul>
                    @foreach ($posts as $post)

                        <li class="border-bottom">
                            <div class="card mb-3 border-0">
                                <div class="row g-0">
                                    <div class="col-md-1">
                                        <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}"
                                            class="img-fluid rounded-start rounded-circle" width="50" alt="...">
                                    </div>
                                    <div class="col-md-11">
                                        <div class="card-body">
                                            <p class="card-text">
                                                <a href="">{{ $post->user()->withTrashed()->first()->name }}</a>
                                            </p>
                                            <h5 class="card-title">
                                                <a href="{{ route('post.detail', $post->slug) }}">{{ $post->title }}</a>
                                            </h5>

                                            <p class="card-text"><small class="text-muted">Last updated 3 mins
                                                    ago</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-3 book-category__aside">
            <div class="book-search__aside ">

                <div class=" filter-group ">
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
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
