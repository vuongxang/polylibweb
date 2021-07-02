@extends('admin.layouts.main')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý file</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <iframe src="{{url('')}}/filemanager/dialog.php?field_id=imgField&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee" frameborder="0" width="100%" height="700"></iframe>
@endsection
