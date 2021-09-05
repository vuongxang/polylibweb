@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách bài viết </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                {{ Session::get('message') }}
            </p>
            @endif

            <div class="d-flex justify-content-between ">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link active" href="#home">
                            Bài viết đã duyệt
                            ( {{$posts->total()}} )</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#menu1">
                            Bài viết chờ duyệt
                            ( {{$posts_pending->total()}} )</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-toggle="tab" class="nav-link" href="#menu2">
                            Bài viết bị từ chối
                            ( {{$posts_rejected->total()}} )</span>
                        </a>
                    </li>
                </ul>
                <div>
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size " class="form-select rounded ">
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="25" @if ($pagesize==25) selected @endif>25</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                    <table class="table table-hover border-right border-left border-bottom table-sm rounded " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Người đăng</th>
                                <th class="text-center" width="100px">Avatar</th>
                                <th>@sortablelink('title','Tiêu đề bài viết')</th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">@sortablelink('created_at','Ngày đăng')</th>
                                <th class="text-center">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts) > 0)
                            @foreach ($posts as $key => $post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($post->user)
                                    {{ $post->user()->withTrashed()->first()->name }}
                                    @else
                                    {{ $post->user()->withTrashed()->first()->name }}&nbsp;
                                    (<span class="text-danger"> Tài khoản đã bị khóa ! </span>)
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($post->user)
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @else
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @endif
                                </td>
                                <td width="300px">{{ $post->title }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                </td>
                                <td class="text-center">
                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    <a class="fas fa-eye text-warning p-1 btn-action" data-toggle="modal" data-target="#detail-{{$post->id}}">
                                    </a>
                                    {{-- <a href="" class="fas fa-eye text-warning p-1 btn-action"></a> --}}
                                    <a onclick="return confirm('Bạn chắc chắn muốn tắt bài viết này?')" href="{{route('post.refuse',$post->id)}}" class="fas fa-power-off text-danger p-1 btn-action"></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">Không tìm thấy bài viết nào !</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $posts->links('vendor.pagination.bootstrap-4') !!}
                </div>
                <div id="menu1" class="tab-pane">
                    <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Người đăng</th>
                                <th class="text-center" width="100px">Avatar</th>
                                <th>@sortablelink('title','Tiêu đề bài viết')</th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">@sortablelink('created_at','Ngày đăng')</th>
                                <th class="text-center">
                                    Hành động
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts_pending) > 0)
                            @foreach ($posts_pending as $key => $post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($post->user)
                                    {{ $post->user()->withTrashed()->first()->name }}
                                    @else
                                    {{ $post->user()->withTrashed()->first()->name }}&nbsp;
                                    (<span class="text-danger"> Tài khoản đã bị khóa ! </span>)
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($post->user)
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @else
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @endif
                                </td>
                                <td width="300px">{{ $post->title }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                </td>
                                <td class="text-center">
                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a class=" mr-2 font-weight-bold btn btn-sm btn-outline-primary btn-acction" data-toggle="modal" data-target="#detail2-{{$post->id}}">Xem</a>
                                        <a href="{{route('post.approv',$post->id)}}" class="font-weight-bold btn btn-sm btn-outline-success btn-acction">Duyệt</a>
                                        <a onclick="return confirm('Bạn chắc chắn từ chối duyệt bài viết này?')" href="{{route('post.refuse',$post->id)}}" class="font-weight-bold ml-2 btn btn-sm btn-outline-danger btn-acction">Từ chối</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">Không tìm thấy bài viết nào !</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $posts_pending->links('vendor.pagination.bootstrap-4') !!}
                </div>
                <div id="menu2" class="tab-pane">
                    <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Người đăng</th>
                                <th class="text-center" width="100px">Avatar</th>
                                <th>@sortablelink('title','Tiêu đề bài viết')</th>
                                <th class="text-center">Ảnh</th>
                                <th class="text-center">@sortablelink('created_at','Ngày đăng')</th>
                                <th class="text-center">
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($posts_rejected) > 0)
                            @foreach ($posts_rejected as $key => $post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if ($post->user)
                                    {{ $post->user()->withTrashed()->first()->name }}
                                    @else
                                    {{ $post->user()->withTrashed()->first()->name }}&nbsp;
                                    (<span class="text-danger"> Tài khoản đã bị khóa ! </span>)
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($post->user)
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @else
                                    <img src="{{ asset($post->user()->withTrashed()->first()->avatar) }}" class="rounded-circle shadow" alt="" width="30" height="30">
                                    @endif
                                </td>
                                <td width="300px">{{ $post->title }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                </td>
                                <td class="text-center">
                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{route('post.approv',$post->id)}}" class="font-weight-bold btn btn-sm btn-outline-success btn-acction">Duyệt lại</a>
                                    {{-- <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')"
                                                        href="" class="font-weight-bold text-danger">Hủy</a> --}}
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center">Không tìm thấy bài viết nào !</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $posts_rejected->links('vendor.pagination.bootstrap-4') !!}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
@foreach ($posts as $post)
<div class="modal fade" id="detail-{{$post->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{$post->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{URL::to('/')}}/post-detail/{{$post->slug}}" frameborder="0" width="100%" height="500px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
            </div>
        </div>
    </div>
</div>
@endforeach
@foreach ($posts_pending as $post)
<div class="modal fade" id="detail2-{{$post->id}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{$post->title}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{URL::to('/')}}/post-detail/{{$post->slug}}" frameborder="0" width="100%" height="500px"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection