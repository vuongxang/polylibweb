@extends('admin.layouts.main')
@section('content')
<!-- Page Heading -->

<div class="card shadow  rounded">
    <div class="card-header ">
        <div class="d-sm-flex align-items-center justify-content-between ">
            <h6 class="m-0 font-weight-bold text-primary">Top sách mượn nhiều nhất</h6>
            <a href="{{route('report.exportTopBorrowBook')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-file-export fa-sm text-white-50"></i> Export file</a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                {{ Session::get('message') }}
            </p>
            @endif
            <div class=" mb-4">
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

            <table class="table table-bordered border-right border-left border-bottom table-sm rounded "  width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 100px;">STT</th>
                        <th >Tên sách</th>
                        <th class="text-center" style="width: 100px;">Ảnh Bìa</th>
                        <th class="text-center" style="width: 150px;">Số lần mượn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($book_borrow_weeks as $key => $book)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td class="align-middle">
                            {{$book->title}}
                        </td>
                        <td class="text-center">
                            <img src="{{asset($book->image)}}" alt="" width="40">
                        </td>
                        <td class="text-center">{{ $book->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


@endsection