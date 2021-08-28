@extends('admin.layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận</h6>
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
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="20" @if ($pagesize==20) selected @endif>20</option>
                            <option value="50" @if ($pagesize==50) selected @endif>50</option>
                        </select>
                    </form>
                </div>
                <div class="data-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Bình luận đã
                                duyệt <span class="badge badge-secondary rounded-circle">{{$comments_approved->total()}}</span> </a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Bình luận chờ duyệt
                            <span class="badge badge-secondary rounded-circle">{{$comments_pending->total()}}</span></a>
                        </li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Bình luận bị xóa
                            <span class="badge badge-secondary rounded-circle">{{$comments_deleted->total()}}</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane in active">
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
                                                @if ($comment->book)
                                                    {{ $comment->book()->withTrashed()->first()->title }}
                                                @else
                                                    {{ $comment->book()->withTrashed()->first()->title }}&nbsp;(<span class="text-danger"> Sách đã bị bỏ vào thùng rác! </span>)
                                                @endif
                                            </td>
                                            <td>{{ $comment->body }}</td>
                                            <td>
                                                {{ date_format($comment->created_at, 'Y-m-d') }}
                                            </td>
                                            <td class="text-center">
                                                @if ($comment->book)
                                                    <a href="{{route('book.detail',$comment->book->slug)}}" class="fas fa-eye text-warning p-1 btn-action"></a>
                                                @endif
                                                <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')" href="{{route('comment.destroy',$comment->id)}}"
                                                    class="fas fa-trash text-danger p-1 btn-action"></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $comments_approved->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                        <div id="menu1" class="tab-pane">
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
                                                    <a onclick="return confirm('Bạn chắc chắn muốn hủy bình luận này?')"
                                                        href="{{route('comment.destroy',$comment->id)}}" class="text-danger p-1 btn-action">Hủy</a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
