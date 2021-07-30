@extends('admin.layouts.main')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đánh giá</h6>
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
                            <option value="5" @if ($pagesize==5) selected @endif>5</option>
                            <option value="10" @if ($pagesize==10) selected @endif>10</option>
                            <option value="15" @if ($pagesize==15) selected @endif>15</option>
                        </select>
                    </form>
                </div>
                <div class="data-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Đánh giá đã duyệt
                            <span>({{count($ratings_approved)}})</span> </a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Đánh giá chờ duyệt
                            <span>({{count($ratings_pending)}})</span></a>
                        </li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Đánh giá bị xóa
                            <span>({{count($ratings_deleted)}})</span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane in active">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>User</th>
                                        <th>Tên Sách</th>
                                        <th>@sortablelink('rating','Số điểm')</th>
                                        <th>@sortablelink('body','Nội dung')</th>
                                        <th>@sortablelink('created_at','Ngày gửi')</th>
                                        <th>
                                            Hành động
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($ratings_approved))
                                        @foreach ($ratings_approved as $key => $rating)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $rating->user->name }}</td>
                                                <td>{{ $rating->book->title }}</td>
                                                <td>
                                                    <div class="book-info-rating">
                                                        <div class="rate-stars">
                                                            @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $rating->body }}</td>
                                                <td>
                                                    {{ date_format($rating->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a onclick="return confirm('Bạn chắc chắn muốn hủy đánh giá này?')" href="{{route('rate.destroy',$rating->id)}}"
                                                        class="fas fa-trash text-danger p-1 btn-action"></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">Không có đánh giá nào !</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {!! $ratings_approved->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                        <div id="menu1" class="tab-pane">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>User</th>
                                        <th>Tên Sách</th>
                                        <th>@sortablelink('rating','Số điểm')</th>
                                        <th>@sortablelink('body','Nội dung')</th>
                                        <th>@sortablelink('created_at','Ngày gửi')</th>
                                        <th>
                                            Hành động
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($ratings_pending) > 0)
                                        @foreach ($ratings_pending as $key => $rating)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $rating->user->name }}</td>
                                                <td>{{ $rating->book->title }}</td>
                                                <td>
                                                    <div class="book-info-rating">
                                                        <div class="rate-stars">
                                                            @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                            @endfor
                                                        </div>
                                                    </div>    
                                                </td>
                                                <td>{{ $rating->body }}</td>
                                                <td>
                                                    {{ date_format($rating->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('rate.approv',$rating->id)}}" class="">Duyệt</a>
                                                    <a onclick="return confirm('Bạn chắc chắn muốn hủy đánh giá này?')"
                                                        href="{{route('rate.destroy',$rating->id)}}" class="text-danger p-1 btn-action">Hủy</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">Không có đánh giá nào !</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>User</th>
                                        <th>Tên Sách</th>
                                        <th>@sortablelink('rating','Số điểm')</th>
                                        <th>@sortablelink('body','Nội dung')</th>
                                        <th>@sortablelink('created_at','Ngày gửi')</th>
                                        <th>
                                            Hành động
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($ratings_deleted) > 0)
                                        @foreach ($ratings_deleted as $key => $rating)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $rating->user->name }}</td>
                                                <td>{{ $rating->book->title }}</td>
                                                <td>
                                                    <div class="book-info-rating">
                                                        <div class="rate-stars">
                                                            @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $rating->body }}</td>
                                                <td>
                                                    {{ date_format($rating->created_at, 'Y-m-d') }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{route('rate.restore',$rating->id)}}" class="text-success">Phục hồi</a>
                                                    <a href="{{route('rate.forcedelete',$rating->id)}}" onclick="return confirm('Bạn chắc chắn muốn xóa đánh giá này?')" class="text-danger">Xóa</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10" class="text-center">Không có đánh giá nào !</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">{!!$ratings_deleted->links('vendor.pagination.bootstrap-4')!!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
