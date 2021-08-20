@extends('admin.layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bài viết chia sẻ</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                        {{ Session::get('message') }}</p>
                @endif
                <div>
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size">
                            <option value="10" @if ($pagesize == 10) selected @endif>10</option>
                            <option value="25" @if ($pagesize == 25) selected @endif>25</option>
                            <option value="50" @if ($pagesize == 50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
                <div class="data-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Bài viết đã
                                duyệt <span class="badge badge-secondary rounded-circle">{{$posts->total()}}</span> </a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Bài viết chờ duyệt
                                <span class="badge badge-secondary rounded-circle">{{$posts_pending->total()}}</span></a>
                        </li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Bài viết bị từ chối
                                <span class="badge badge-secondary rounded-circle">{{$posts_rejected->total()}}</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane in active">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Người đăng</th>
                                        <th>@sortablelink('title','Tiêu đề')</th>
                                        <th>Ảnh</th>
                                        <th>@sortablelink('created_at','Ngày đăng')</th>
                                        <th>
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
                                                    <a href="">
                                                        <img src="{{ asset($post->user->avatar) }}"
                                                            class="rounded-circle shadow" alt="" width="30">
                                                        {{ $post->user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $post->title }}</td>
                                                <td>
                                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                                </td>
                                                <td>
                                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="" class="fas fa-eye text-warning p-1 btn-action"></a>
                                                    <a onclick="return confirm('Bạn chắc chắn muốn tắt bài viết này?')"
                                                        href="{{route('post.refuse',$post->id)}}" class="fas fa-power-off text-danger p-1 btn-action"></a>
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
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Người đăng</th>
                                        <th>@sortablelink('title','Tiêu đề')</th>
                                        <th>Ảnh</th>
                                        <th>@sortablelink('created_at','Ngày đăng')</th>
                                        <th>
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
                                                    <a href="">
                                                        <img src="{{ asset($post->user->avatar) }}"
                                                            class="rounded-circle shadow" alt="" width="30">
                                                        {{ $post->user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $post->title }}</td>
                                                <td>
                                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                                </td>
                                                <td>
                                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('post.approv',$post->id)}}" class="font-weight-bold text-success">Duyệt</a> |
                                                    <a onclick="return confirm('Bạn chắc chắn từ chối duyệt bài viết này?')"
                                                        href="{{route('post.refuse',$post->id)}}" class="font-weight-bold text-danger">Từ chối</a>
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
                            {!! $posts_pending->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                        <div id="menu2" class="tab-pane">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Người đăng</th>
                                        <th>@sortablelink('title','Tiêu đề')</th>
                                        <th>Ảnh</th>
                                        <th>@sortablelink('created_at','Ngày đăng')</th>
                                        <th>
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
                                                    <a href="">
                                                        <img src="{{ asset($post->user->avatar) }}"
                                                            class="rounded-circle shadow" alt="" width="30">
                                                        {{ $post->user->name }}
                                                    </a>
                                                </td>
                                                <td>{{ $post->title }}</td>
                                                <td>
                                                    <img src="{{ asset($post->thumbnail) }}" alt="" width="30">
                                                </td>
                                                <td>
                                                    {{ date_format($post->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('post.approv',$post->id)}}" class="font-weight-bold text-success">Duyệt lại</a>
                                                    {{-- <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')"
                                                        href="" class="font-weight-bold text-danger">Hủy</a> --}}
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
                            {!! $posts_rejected->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
