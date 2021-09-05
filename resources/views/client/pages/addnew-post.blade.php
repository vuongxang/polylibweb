@extends('client.layouts.index')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
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
            <!-- <form action="{{ route('post.store') }}" method="post" id="postForm" enctype="multipart/form-data"> -->
            <form role="form" action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-8">
                        <div class="form-group">
                            <label for="my-input">Tiêu đề bài viết</label><br>
                            <input id="my-input" class="form-control" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}">
                            @if ($errors->has('title'))
                            <span class="text-danger text-message">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="thumbnail">Ảnh đại diện bài viết</label>

                            
                            <div class="form-control thumbnail-file__wrap">
                                <input type="file" id="thumbnail" name="thumbnail" value="{{ old('thumbnail') }}" class="thumbnail-file-input" >
                            </div>
                            @if ($errors->has('thumbnail'))
                            <span class="text-danger text-message ">{{ $errors->first('thumbnail') }}</span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="form-group" id="choice-multiple-form">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Danh mục</label>

                    <select id="choices-multiple-remove-button" class="form-select" name="cate_id[]" placeholder="Chọn tối đa 5 danh mục" multiple>
                        @foreach ($cates as $cate)
                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('cate_id'))
                    <span class="text-danger text-message">{{ $errors->first('cate_id') }}</span>
                    @endif
                </div>


                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Tệp đính kèm </label>
                    <div class="attachments-wrap">

                        <!-- <div class=" attachments-list ">

                            <div class="attachments-item">
                                <label class="attachments-label" for="">Tên tệp:</label>
                                <input type="text" class="form-control attachments-title" name="file_title[]" placeholder="Tên tệp đính kèm">
                            </div>
                            <div class="attachments-item">
                                <label class="attachments-label">Chọn file :</label>
                                <div class=" attachments-file ">
                                    <input type="file" class=" attachments-file__input" name="file_upload[]" value="{{ old('thumbnail') }}">
                                </div>
                            </div>
                            <div class="attachments-item "><a href="javascript:;" class="attachments-item__link"><i class="fa fa-trash"></i> </a></div>

                        </div> -->
                    </div>

                    <div class="attachments-button">
                        <a href="javascript:;" onclick="addFileAttachment();" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> Thêm tệp đính kèm</a>
                    </div>

                </div>











                <!-- <div class="card mb-4">
                    <div class="card-body">
                        <h4 class="card-title text-center">Tệp đính kèm (Nếu có)</h4>
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
                                        <td><input type="file" name="file_upload[]"></td>
                                        <td class="text-message0"><a href="javascript:;" class="badge bg-danger"><i class="fa fa-trash"></i> Delete</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center"><a href="javascript:;" onclick="addfaqs();" class="badge bg-success"><i class="fa fa-plus"></i> ADD NEW</a></div>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Nội dung</label><br>

                    <textarea name="content" id="editor1" rows="20" class="form-control" placeholder="Nội dung">{{old('content')}}
                    </textarea>
                    @if ($errors->has('content'))
                    <span class="text-danger text-message ">{{ $errors->first('content') }}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Lưu</button>
                    <a href="{{route('cate.index')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
                </div>
            </form>
            <div class="mt-4" id="progress" style="display: none">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="alert alert-success text-center" id="progress-arlert" style="display: none">Thêm sách thành công
                !</div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdn.tiny.cloud/1/z61mklx0qjtdxp2smr8tj2bcs3dkzef4894ven0bm30q2dv9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src="{{asset('js/client/post-form.js')}}"></script>
@endsection