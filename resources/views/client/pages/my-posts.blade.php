@extends('client.layouts.index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/history.css') }}">
@endsection
@section('title', 'PolyLib')
@section('content')
<div class="container">
    <div class=" profile-info">
        <div class="row ho-so-ca-nhan">
            <div class="col-md-12 ho-so-ca-nhan">
                <h2>Bài viết của tôi</h2>
            </div>
        </div>
        @if (session('message'))
            <div class="alert alert-success text-center">
                <h1 class="text-success" style="font-size: 20pt; font-weight:700">{{ session('message') }}</h1>
            </div>
        @endif
        <div class="data-tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Bài viết của tôi</a></li>
                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Bài viết yêu thích</a></li>
            </ul>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <table id="example" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td class="text-center">Ảnh bài viết</td>
                                <td>Tên bài viết</td>
                                <td>Trạng thái</td>
                                <td class="text-center">
                                    <a href="{{ route('post.create') }}" class="btn btn-success shadow rounded-0"><i class="fas fa-plus-circle mr-2"></i>ADD NEW</a>
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts) > 0)
                            @foreach ($posts as $key => $post)
                            <tr>
                                <td data-label="STT" scope="row">{{ $key + 1 }}</td>
                                <td data-label="Ảnh"  class="img-center">
                                    <a href="{{ route('post.detail', $post->slug) }}">
                                        <img src="{{ asset($post->thumbnail) }}" width="40" alt="Ảnh bài viết">
                                    </a>
                                </td>
                                <td  data-label="Tên bài viết" >
                                <a style="color:black" href="{{ route('post.detail', $post->slug) }}">{{$post->title}}</a>
                                </td>
                                <td  data-label="Trạng thái" >
                                    @if ($post->status==1)
                                        <span class="badge badge-info bg-success">Hiển thị</span>
                                    @elseif($post->status==0)
                                        <span class="badge badge-info bg-warning">Chờ duyệt</span>
                                    @elseif($post->status==2)
                                    <span class="badge badge-info bg-danger">Từ chối</span>
                                    @endif
                                </td>
                                <td  data-label="hành động"  class="img-center">
                                    <a href="{{ route('post.create') }}" class="fas fa-plus-circle mr-2 p-1 btn-action add-post"></a>
                                    <a href="{{route('post.detail',$post->slug)}}" class="fa fa-eye text-warning p-1 btn-action"></a>
                                    <a href="{{route('post.edit',$post->id)}}" class="fa fa-edit text-success p-1 btn-action"></a>
                                    <a onclick="return confirm('Bạn chắc chắn xóa')" href="{{route('post.destroy',$post->id)}}" class="fas fa-trash-alt text-danger p-1 btn-action"></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Bạn chưa tạo bài viết nào!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">{!!$posts->links('vendor.pagination.bootstrap-4')!!}</div>
                </div>
                <div id="menu1" class="tab-pane">
                    <table id="example" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <td>STT</td>
                                <td>Ảnh bài viết</td>
                                <td>Tên bài viết</td>
                                <td>Người đăng</td>
                                <td class="text-center" style="width: 150px;">Hành động</td>
                            </tr>
                        </thead>
                        <tbody>

                            
                            @if (count($wishlists)>0)
                                @foreach ($wishlists as $key => $wishlist)
                                    @if ($wishlist->id == true)
                                        @if ($wishlist->post)
                                            <tr>
                                                <td>{{ $key +1 }}</td>
                                                <td class="">
                                                    <a href="{{ route('post.detail', $wishlist->post->slug) }}">
                                                        <img src="{{ asset($wishlist->post->thumbnail) }}" width="40" alt="Ảnh bài viết">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('post.detail', $wishlist->post->slug) }}" style="color:#000">
                                                        {{ $wishlist->post->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('post.detail', $wishlist->post->slug) }}" style="color:#000">
                                                        {{ $wishlist->post->user()->withTrashed()->first()->name }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('post.wishlist.destroy',['id'=>$wishlist->post->id])}}"
                                                        class="fas fa-trash text-danger"></a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                            @else
                            <tr>
                                <td colspan="8" class="text-center">Bạn chưa có bài viết yêu thích nào!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection