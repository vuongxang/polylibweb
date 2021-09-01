@extends('admin.layouts.main')
@section('content')
<!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-end mb-4">
        <a href="{{route('report.exportTopBorrowBook')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-file-export fa-sm text-white-50"></i> Export file</a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Top sách mượn nhiều nhất</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }} text-center">
                        {{ Session::get('message') }}</p>
                @endif
                <div class="pb-2 mb-4 border-bottom">   
                    <form action="" method="get" id="form-page-size">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 row">
                                <label class="col-5" for="page_size">Chọn số bản ghi</label>
                                <select name="page_size" id="page_size" class="col-5 form-select-report">
                                    <option value="10" @if ($pagesize==10) selected @endif>Top 10</option>
                                    <option value="20" @if ($pagesize==20) selected @endif>Top 20</option>
                                    <option value="50" @if ($pagesize==50) selected @endif>Top 50</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 row">
                                <label for="total_day" class="col-5">Thời gian</label>
                                <select name="total_day" id="total_day" class="col-5 form-select-report">
                                    <option value="7" @if ($total_day==7) selected @endif>1 tuần trước</option>
                                    <option value="30" @if ($total_day==30) selected @endif>30 ngày trước</option>
                                    <option value="365" @if ($total_day==365) selected @endif>1 năm trước</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div>   
                    <form action="" method="get" id="form-total-day">
                        
                    </form>
                </div> --}}
                <div class="data-tabs">
                    <div class="tab-content">
                        <div id="home" class="tab-pane in active">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên sách</th>
                                        <th>Ảnh Bìa</th>
                                        <th style="width: 150px;">Số lần mượn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($book_borrow_weeks as $key => $book)
                                            <td>{{ $key+1 }}</td>
                                            <td class="align-middle">
                                                {{$book->title}}
                                            </td>
                                            <td>
                                                <img src="{{asset($book->image)}}" alt="" width="40">
                                            </td>
                                            <td>{{ $book->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
