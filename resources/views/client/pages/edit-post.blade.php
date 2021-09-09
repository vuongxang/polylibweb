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
            <form action="{{route('post.update',$post->id)}}" method="post" id="postForm" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="my-input">Tiêu đề bài viết</label><br>
                    <input id="my-input" class="form-control" type="text" name="title" placeholder="tiêu đề" value="{{old('title',$post->title)}}">
                    @if ($errors->has('title'))
                    <span class="text-danger">{{$errors->first('title')}}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="thumbnail">Ảnh đại diện bài viết</label>
                    <div class="thumbnail__wrap">
                        <div class="thubnail-img">
                            <img src="{{asset($post->thumbnail)}}" alt="" width="100">
                        </div>
                        <div class="col-4">
                            <div class="form-control thumbnail-file__wrap">
                                <input id="thumbnail" type="file" name="thumbnail">
                            </div>
                            @if ($errors->has('thumbnail'))
                            <span class="text-danger">{{$errors->first('thumbnail')}}</span>
                            @endif
                        </div>
                    </div>



                </div>
                <div class="form-group" id="choice-multiple-form">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Danh mục</label>

                    <select id="choices-multiple-remove-button" name="cate_id[]" placeholder="Chọn tối đa 5 danh mục" multiple>
                        @foreach ($cates as $cate)
                        <option value="{{$cate->id}}" @foreach ($post->cates as $c)
                            @if ($c->id==$cate->id)
                            selected
                            @endif
                            @endforeach
                            >{{$cate->name}}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('cate_id'))
                    <span class="text-danger">{{$errors->first('cate_id')}}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Tệp đính kèm </label>
                    <div class="attachments-wrap">
                    @foreach ($post->postFiles as $key => $postFile)
                            <!-- <li>
                                <a href="{{asset($postFile->url)}}">{{basename($postFile->url)}}</a>
                                <span class="btn btn-outline-danger js-span" id="{{$postFile->id}}">&#10006</span>
                            </li> -->
                            
                        <div class=" attachments-list ">

                            <div class="attachments-item">
                                <label class="attachments-label" for="">Tên tệp:</label>
                                <span class=" attachments-link">{{$postFile->title}}</span>
                            </div>
                            <div class="attachments-item">
                                <label class="attachments-label">File : </label>
                                <div class=" attachments-file ">
                                    <!-- <input type="file" class=" attachments-file__input"  value="{{ old('thumbnail') }}"> -->
                                    <a href="{{asset($postFile->url)}}" target="_blank">{{basename($postFile->url)}}</a>

                                </div>
                            </div>
                            <div class="attachments-item "><a href="javascript:;" class="attachments-item__link js-remove-file" id="{{$postFile->id}}"><i class="fa fa-trash"></i> </a></div>
                        </div>
                        @endforeach
                        <input type="hidden" name="file_close" id="file_close">
                    </div>

                    <div class="attachments-button">
                        <a href="javascript:;" onclick="addFileAttachment();" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i> Thêm tệp đính kèm</a>
                    </div>

                </div>




                <!-- <div class="card mb-4">
                    <div class="card-body">
                        <label> Đính kèm tệp (Nếu có)</label>
                        @if ($post->postFiles)
                        <ul>
                            @foreach ($post->postFiles as $key => $postFile)
                            <li>
                                <a href="{{asset($postFile->url)}}">{{$postFile->title}}</a>
                                <span class="btn btn-outline-danger js-span" id="{{$postFile->id}}">&#10006</span>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        <input type="hidden" name="file_close" id="file_close">
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
                                        <td class="mt-10"><a href="javascript:;" class="badge bg-danger"><i class="fa fa-trash"></i> Delete</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center"><a href="javascript:;" onclick="addfaqs();" class="badge bg-success"><i class="fa fa-plus"></i> ADD NEW</a></div>
                    </div>
                </div> -->
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputName">Nội dung</label><br>
                    @if ($errors->has('content'))
                    <span class="text-danger">{{$errors->first('content')}}</span>
                    @endif
                    <textarea name="content" id="editor1" rows="30" class="form-control" placeholder="Nội dung">
                    {{old('content',$post->content)}}
                    </textarea>
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
            <div class="alert alert-success text-center" id="progress-arlert" style="display: none">Thêm sách thành công !</div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
<script src="https://cdn.tiny.cloud/1/hmuw3s2zqh2hz2ctu3t8rxpvxh61d6ci6pkldvwxndprwi2a/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script src="{{asset('js/client/post-form.js')}}"></script>
@endsection