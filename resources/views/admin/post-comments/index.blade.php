@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận bài viết</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                {{ Session::get('message') }}
            </p>
            @endif
            <div class="data-tabs">
                <div class="d-flex justify-content-between ">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Bình luận đã
                                duyệt ({{$comments_approved->total()}})</span> </a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Bình luận chờ duyệt
                                ({{$comments_pending->total()}})</span></a>
                        </li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Bình luận bị xóa
                                ({{$comments_deleted->total()}})</span></a></li>
                    </ul>
                    <form action="" method="get" id="form-page-size">
                        <label for="">Chọn số bản ghi</label>
                        <select name="page_size" id="page_size" class="form-select rounded">
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="20" @if ($pagesize==20) selected @endif>20</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>

                <div class="tab-content">
                    <div id="home" class="tab-pane in active">
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>email</th>
                                    <th>Tên Sách</th>
                                    <th>Nội dung</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày bình luận')</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comments_approved as $key => $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>
                                        @if ($comment->user)
                                        {{ $comment->user()->withTrashed()->first()->email }}
                                        @else
                                        {{ $comment->user()->withTrashed()->first()->email }}&nbsp;(<span class="text-danger"> Tài khoản đang bị khóa! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($comment->post)
                                        {{ $comment->post()->withTrashed()->first()->title }}
                                        @else
                                        {{ $comment->post()->withTrashed()->first()->title }}&nbsp;(<span class="text-danger"> Sách đã bị bỏ vào thùng rác! </span>)
                                        @endif
                                    </td>
                                    <td>{{ $comment->body }}</td>
                                    <td class="text-center">{{ date_format($comment->created_at, 'Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if ($comment->post)
                                        <a href="{{route('post.detail',$comment->post->slug)}}" class="fas fa-eye text-warning p-1 btn-action"></a>
                                        @endif
                                        <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')" href="{{route('postComment.destroy',$comment->id)}}" class="fas fa-trash text-danger p-1 btn-action"></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $comments_approved->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                    <div id="menu1" class="tab-pane">
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>email</th>
                                    <th>Tên Sách</th>
                                    <th>Nội dung</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày bình luận')</th>
                                    <th class="text-center" style="width: 250px">Hành động</th>
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
                                        @if ($comment->post)
                                        {{ $comment->post->title }}
                                        @else
                                        <span class="text-danger">Sách tạm thời bị xóa !</span>
                                        @endif
                                    </td>
                                    <td>{{ $comment->body }}</td>
                                    <td class="text-center">{{ date_format($comment->created_at, 'Y-m-d') }}</td>
                                    <td class="text-center">
                                        <div class="button-group">
                                            @if ($comment->user)
                                            <a href="{{route('postComment.approv',$comment->id)}}" class="font-weight-bold btn btn-sm btn-outline-success btn-acction">Duyệt</a>
                                            @endif
                                            <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')" href="{{route('postComment.destroy',$comment->id)}}" class="ml-2 font-weight-bold btn btn-sm btn-outline-danger btn-acction">Hủy</a>
                                        </div>
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
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@sortablelink('id','ID')</th>
                                    <th>email</th>
                                    <th>Tên Sách</th>
                                    <th>Nội dung</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày bình luận')</th>
                                    <th class="text-center" style="width: 250px">Hành động</th>
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
                                        @if ($comment->post)
                                        {{ $comment->post->title }}
                                        @else
                                        <span class="text-danger">Sách đã bị xóa!</span>
                                        @endif
                                    </td>
                                    <td>{{ $comment->body }}</td>
                                    <td class="text-center">{{ date_format($comment->created_at, 'Y-m-d') }}</td>
                                    <td class="text-center">
                                        <div class="button-group">
                                            <a href="{{route('postComment.restore',$comment->id)}}" class="font-weight-bold btn btn-sm btn-outline-success btn-acction">Phục hồi</a>
                                            <a href="{{route('postComment.forcedelete',$comment->id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa bình luận này?')" class="ml-2 font-weight-bold btn btn-sm btn-outline-danger btn-acction">Xóa</a>
                                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>


@endsection