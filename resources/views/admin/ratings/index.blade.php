@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4 rounded">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách đánh giá</h6>
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
                        <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#home">Đánh giá đã duyệt
                                <span>({{$ratings_approved->total()}})</span> </a></li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu1">Đánh giá chờ duyệt
                                <span>({{$ratings_pending->total()}})</span></a>
                        </li>
                        <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#menu2">Đánh giá bị xóa
                                <span>({{$ratings_deleted->total()}})</span></a></li>
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
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded " id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th style="width: 1rem">Email</th>
                                    <th style="width: 200px">Tên Sách</th>
                                    <th style="width: 150px">@sortablelink('rating','Đánh giá')</th>
                                    <th>@sortablelink('body','Nội dung')</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày gửi')</th>
                                    <th>
                                        Hành động
                                    </th>
                                </tr>
                            </thead>
                            <tbody >
                                @if (count($ratings_approved))
                                @foreach ($ratings_approved as $key => $rating)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($rating->user)
                                        {{ $rating->user()->withTrashed()->first()->email }}
                                        @else
                                        {{ $rating->user()->withTrashed()->first()->email }}&nbsp;(<span class="text-danger"> Tài khoản đang bị khóa! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($rating->book)
                                        {{ $rating->book()->withTrashed()->first()->title }}
                                        @else
                                        {{ $rating->book()->withTrashed()->first()->title }}&nbsp;(<span class="text-danger"> Sách đang bị cho vào thùng rác ! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        <div class="book-info-rating">
                                            <div class="rate-stars">
                                                @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                    @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $rating->body }}</td>
                                    <td class="text-center">{{ date_format($rating->created_at, 'd-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        <a onclick="return confirm('Bạn chắc chắn muốn hủy đánh giá này?')" href="{{route('rate.destroy',$rating->id)}}" class="fas fa-trash text-danger p-1 btn-action"></a>
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
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>User</th>
                                    <th>Tên Sách</th>
                                    <th>@sortablelink('rating','Đánh giá')</th>
                                    <th>@sortablelink('body','Nội dung')</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày gửi')</th>
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
                                    <td>
                                        @if ($rating->user)
                                        {{ $rating->user()->withTrashed()->first()->email }}
                                        @else
                                        {{ $rating->user()->withTrashed()->first()->email }}&nbsp;(<span class="text-danger"> Tài khoản đang bị khóa! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($rating->book)
                                        {{ $rating->book()->withTrashed()->first()->title }}
                                        @else
                                        {{ $rating->book()->withTrashed()->first()->title }}&nbsp;(<span class="text-danger"> Sách đang bị cho vào thùng rác ! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        <div class="book-info-rating">
                                            <div class="rate-stars">
                                                @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                    @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $rating->body }}</td>
                                    <td class="text-center">{{ date_format($rating->created_at, 'Y-m-d') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('rate.approv',$rating->id)}}" class="">Duyệt</a>
                                        <a onclick="return confirm('Bạn chắc chắn muốn hủy đánh giá này?')" href="{{route('rate.destroy',$rating->id)}}" class="text-danger p-1 btn-action">Hủy</a>
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
                        <table class="table table-hover border-right border-left border-bottom table-sm rounded" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>User</th>
                                    <th>Tên Sách</th>
                                    <th>@sortablelink('rating','Đánh giá')</th>
                                    <th>@sortablelink('body','Nội dung')</th>
                                    <th class="text-center">@sortablelink('created_at','Ngày gửi')</th>
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
                                    <td>
                                        @if ($rating->user)
                                        {{ $rating->user()->withTrashed()->first()->email }}
                                        @else
                                        {{ $rating->user()->withTrashed()->first()->email }}&nbsp;(<span class="text-danger"> Tài khoản đang bị khóa! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        @if ($rating->book)
                                        {{ $rating->book()->withTrashed()->first()->title }}
                                        @else
                                        {{ $rating->book()->withTrashed()->first()->title }}&nbsp;(<span class="text-danger"> Sách đang bị cho vào thùng rác ! </span>)
                                        @endif
                                    </td>
                                    <td>
                                        <div class="book-info-rating">
                                            <div class="rate-stars">
                                                @for ($i=0; $i < $rating->rating; $i++) <i class="fas fa-star text-warning"></i>
                                                    @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $rating->body }}</td>
                                    <td class="text-center">{{ date_format($rating->created_at, 'Y-m-d') }}
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