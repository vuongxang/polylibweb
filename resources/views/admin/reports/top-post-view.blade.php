@extends('admin.layouts.main')
@section('content')

<div class="card shadow rounded">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Top sách lượt xem nhiều nhất</h6>
            <a href="{{route('report.exportTopViewPost')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file-export fa-sm text-white-50"></i> Export file</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                {{ Session::get('message') }}
            </p>
            @endif
            <div class="mb-4 ">
                <form action="" method="get" id="form-page-size">
                    <div class="row d-md-flex align-items-center">
                        <div class="col-sm-12 col-md-6 row  d-flex align-items-center">
                            <label class="col-4 m-0" for="page_size ">Chọn số bản ghi:</label>
                            <select name="page_size" id="page_size" class="col-3 form-select-report border border-dark text-dark rounded ">
                                <option value="10" @if ($pagesize==10) selected @endif>Top 10</option>
                                <option value="20" @if ($pagesize==20) selected @endif>Top 20</option>
                                <option value="50" @if ($pagesize==50) selected @endif>Top 50</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 row d-md-flex align-items-center">
                            <label for="total_day " class="col-3 m-0">Thời gian:</label>
                            <select name="total_day" id="total_day" class="col-4 form-select-report border border-dark text-dark rounded">
                                <option value="7" @if ($total_day==7) selected @endif>1 tuần trước</option>
                                <option value="30" @if ($total_day==30) selected @endif>30 ngày trước</option>
                                <option value="365" @if ($total_day==365) selected @endif>1 năm trước</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="data-tabs">
                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <table class="table table-bordered border-right border-left border-bottom table-sm rounded " width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Người đăng</th>
                                    <th style="width: 30rem;">Tiêu đề bài viết</th>
                                    <th class="text-center">Ảnh Bài Viết</th>
                                    <th class="text-center">Lượt xem</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($post_views as $key => $post)
                                <td>{{ $key+1 }}</td>
                                <td>{{ $post->user_name }}</td>
                                <td>
                                    {{$post->title}}
                                </td>
                                <td class="text-center">
                                    <img src="{{asset($post->thumbnail)}}" alt="" width="40">
                                </td>
                                <td class="text-center">{{ $post->total_view }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div id="menu1" class="tab-pane">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>@sortablelink('id','ID')</th>
                                        <th>email</th>
                                        <th>Tên Sách</th>
                                        <th>Nội dung</th>
                                        <th>@sortablelink('created_at','Ngày bình luận')</th>
                                        <th>
                                            Hành động
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($comments_pending) > 0)
                                        @foreach ($comments_pending as $key => $comment)
                                            <tr>
                                                <td>{{ $comment->id }}</td>
                    <td>
                        @if ($comment->user)
                        {{ $comment->user->email }}
                        @else
                        <span class="text-danger">Tài khoản đã bị khóa!</span>
                        @endif
                    </td>
                    <td>
                        @if ($comment->book)
                        {{ $comment->book->title }}
                        @else
                        <span class="text-danger">Sách tạm thời bị xóa !</span>
                        @endif
                    </td>
                    <td>{{ $comment->body }}</td>
                    <td>
                        {{ date_format($comment->created_at, 'Y-m-d') }}
                    </td>
                    <td class="text-center">
                        @if ($comment->user)
                        <a href="{{route('comment.approv',$comment->id)}}" class="">Duyệt</a>
                        @endif
                        <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')" href="{{route('comment.destroy',$comment->id)}}" class="text-danger p-1 btn-action">Hủy</a>
                    </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="10" class="text-center">Không có bình luận nào !</td>
                    </tr>
                    @endif
                    </tbody>
                    </table>
                </div>
                <div id="menu2" class="tab-pane">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>@sortablelink('id','ID')</th>
                                <th>email</th>
                                <th>Tên Sách</th>
                                <th>Nội dung</th>
                                <th>@sortablelink('created_at','Ngày bình luận')</th>
                                <th>
                                    Hành động
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($comments_deleted) > 0)
                            @foreach ($comments_deleted as $key => $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>
                                    @if ($comment->user)
                                    {{ $comment->user->email }}
                                    @else
                                    <span class="text-danger">Tài khoản đã bị khóa!</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($comment->book)
                                    {{ $comment->book->title }}
                                    @else
                                    <span class="text-danger">Sách đã bị xóa!</span>
                                    @endif
                                </td>
                                <td>{{ $comment->body }}</td>
                                <td>
                                    {{ date_format($comment->created_at, 'Y-m-d') }}
                                </td>
                                <td class="text-center">
                                    <a href="{{route('comment.restore',$comment->id)}}" class="text-success">Phục hồi</a>
                                    <a href="{{route('comment.forcedelete',$comment->id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này?')" class="text-danger">Xóa</a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10" class="text-center">Không có bình luận nào !</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</div>


@endsection