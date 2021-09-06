@extends('admin.layouts.main')
@section('css')
<link href="{{asset('adminthame/css/book-form.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Cập nhật sách</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-10 offset-1">
            <form action="{{route('book.update',$model->id)}}" method="post" class="mt-4 mb-4">
                @csrf
                <div class="row mb-2">
                    <div class="form-group form-group col-sm-12 col-lg-6">
                        <label class="text-dark font-weight-bold" for="exampleInputTitle">Tên Sách</label>
                        <input type="text" class="form-control" id="exampleInputTitle" placeholder="tên sách" name="title" value="{{ old('title',$model->title) }}">
                        @if ($errors->has('title'))
                        <span class="text-danger">{{$errors->first('title')}}</span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12 col-lg-6">
                        <label class="text-dark font-weight-bold" for="exampleInputFile">Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="1" @if ($model->status == 1) selected @endif>Hiện</option>
                            <option value="0" @if ($model->status == 0) selected @endif>Ẩn</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="form-group col-6">
                        <label class="text-dark font-weight-bold" for="exampleInputFile">Ảnh bìa sách</label>
                        <br>
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
                            <i class="fas fa-camera mr-2"></i>Chọn ảnh
                        </button>
                        <div class="show_image" class="mt-2">
                            <img src="{{ old('image',$model->image) }}" class="img-thumbnail" id="show_img" width="200">
                        </div>
                        <input type="text" id="image" name="image" hidden class="form-control" value="{{ old('image',$model->image) }}">
                        @if ($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                        @endif
                    </div>
                    <div class="form-group col-6">
                        <label class="text-dark font-weight-bold" for="exampleInputDate">Ngày đăng</label>
                        <input type="date" class="form-control" id="exampleInputDate" name="publish_date_from" value="{{ old('publish_date_from',$model->publish_date_from) }}">
                        @if ($errors->has('publish_date_from'))
                        <span class="text-danger">{{$errors->first('publish_date_from')}}</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="form-group col-sm-12 col-lg-6">
                        <label class="text-dark font-weight-bold" for="exampleInputFile">Danh mục</label>
                        <br>
                        <select id="choices-multiple-remove-button" name="cate_id[]" placeholder="Select upto 10 tags" multiple class="form-control">
                            @foreach ($cates as $cate)
                            <option value="{{$cate->id}}" @foreach ($model->categories as $category)
                                @if ($category->id==$cate->id)
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
                    <div class="form-group col-sm-12 col-lg-6">
                        <label class="text-dark font-weight-bold" for="exampleInputFile">Tác giả</label>
                        <br>
                        <select id="choices-multiple-remove-button" name="author_id[]" placeholder="Select upto 10 tags" multiple class="form-control">
                            @foreach ($authors as $author)
                            <option value="{{$author->id}}" @foreach ($model->authors as $au)
                                @if ($au->id==$author->id)
                                selected
                                @endif
                                @endforeach
                                >{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold">Audio file (Nếu có)</label><br>
                    <button type="button" class="btn btn-primary mb-2 btn-sm" data-toggle="modal" data-target="#audio_gallery">
                        <i class="far fa-file-audio mr-2"></i>Chọn file
                    </button>
                    <div class="audio-gallery" class="mb-2">
                        @if ($model->bookAudios)
                        @foreach ($model->bookAudios as $item)
                        <div class="d-flex align-items-center mb-1">
                            <audio src="{{$item->url}}" id="show_list_audio" controls>
                                Trình duyệt không hỗ trợ phát âm thanh
                            </audio>
                            <span aria-hidden="true" value="{{$item->url}}" class="btn btn-outline-danger cancle-audio">&times;</span>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <input type="hidden" id="list_audio" name="list_audio" class="form-control" value="{{ old('list_audio',$book_audios) }}">
                    @if ($errors->has('list_audio'))
                    <span class="text-danger">{{$errors->first('list_audio')}}</span>
                    @endif
                    @if (Session::get('error_audio'))
                    <span class="text-danger">{{ Session::get('error_audio') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputFile">Nội dung sách</label><br>
                    <button type="button" class="btn btn-primary mb-2 btn-sm" data-toggle="modal" data-target="#image_gallery">
                        <i class="fas fa-camera mr-2"></i>Chọn ảnh
                    </button>
                    {{-- horizonal scroll css --}}
                    <div class="scrolling-wrapper row flex-row flex-nowrap mt-4 pb-4 pt-3 img-gallery">
                        @if ($model->bookGalleries)
                        @foreach ($model->bookGalleries as $item)
                        <div class="col-2 text-center position-relative ">
                            <span aria-hidden="true" value="{{$item->url}}" style="width:20px; height:20px;z-index:10;right:0;top:0;transform:translateY(-50%)" class="btn btn-secondary btn-sm d-flex justify-content-center align-items-center rounded-circle position-absolute  cancle-image"><i class="fas fa-times"></i></span>
                            <div class="card ml-2 ">
                                <img src="{{$item->url}}" alt="" id="show_list_img" width="100%">
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <input type="hidden" id="list_image" name="list_image" class="form-control" value="{{ old('list_image',$book_galleries) }}">
                    @if ($errors->has('list_image'))
                    <span class="text-danger">{{$errors->first('list_image')}}</span>
                    @endif
                    @if (Session::get('error_image'))
                    <span class="text-danger">{{ Session::get('error_image') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="text-dark font-weight-bold" for="exampleInputDesc">Thông tin chi tiết</label>
                    <textarea type="text" rows="10" class="form-control" id="exampleInputDesc" placeholder="Nhập thông tin chi tiết" name="description">{{ old('description',$model->description) }}</textarea>
                    @if ($errors->has('description'))
                    <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark btn-sm shadow-lg">Cập nhật</button>
                    <a href="{{route('book.index')}}" class="btn btn-danger btn-sm shadow">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thư viện ảnh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{url('')}}/filemanager/dialog.php?field_id=image&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee" frameborder="0" width="100%" height="500"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Lưu</button> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="image_gallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thư viện ảnh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{url('')}}/filemanager/dialog.php?field_id=list_image&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee" frameborder="0" width="100%" height="500"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Lưu</button> --}}
            </div>
        </div>
    </div>
</div>
<!-- Modal audio -->
<div class="modal fade" id="audio_gallery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Quản lý file</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="{{ url('') }}/filemanager/dialog.php?field_id=list_audio&lang=en_EN&akey=urDy9RR9agzmDEQw7u7gPO6qee" frameborder="0" width="100%" height="500"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Lưu</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('adminthame/js/book-form.js') }}"></script>
@endsection