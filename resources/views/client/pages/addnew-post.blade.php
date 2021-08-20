@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="{{ asset('css/client/pages/post-form.css') }}">
@endsection
@section('title', 'PolyLib')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }} text-center">{{ Session::get('message') }}</p>
            @endif
            <form action="" method="post">
                @csrf
                <div class="form-group">
                    <input id="my-input" class="form-control" type="text" name="title" placeholder="tiêu đề">
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Danh mục</label>
                    <br>
                    <select id="choices-multiple-remove-button" name="cate_id[]" placeholder="Chọn tối đa 5 danh mục" multiple>
                        @foreach ($cates as $cate)
                            <option value="{{$cate->id}}">{{$cate->name}}</option>
                        @endforeach
                    </select> 
                </div>
                <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-center">Đính kèm tệp (Nếu có)</h4>
                        <hr>
                        <div class="table-responsive">
                            <table id="faqs" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>File</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" class="form-control" name="file_title[]" placeholder="tên file"></td>
                                        <td><input type="file" name="file[]"></td>
                                        <td class="mt-10"><a href="javascript:;" class="badge bg-danger"><i class="fa fa-trash"></i> Delete</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center"><a href="javascript:;" onclick="addfaqs();" class="badge bg-success"><i class="fa fa-plus"></i> ADD NEW</a></div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="content" id="exampleInputDesc" rows="30" class="tinymce-editor" placeholder="Nội dung">
                    </textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Lưu</button>
                    <a href="{{route('cate.index')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection