@extends('admin.layouts.main')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Thêm mới danh mục</h6>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-2">
            <form action="{{route('cate.update',$model->id)}}" method="post" enctype="multipart/form-data" class="mt-4 mb-4">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Tên danh mục</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="tên danh mục" name="name" value="{{ old('name',$model->name) }}">
                    @if ($errors->has('name'))
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Ảnh</label>
                    <input type="file" id="exampleInputFile" name="image">
                    <img src="{{ asset(old('image', $model->image)) }}" alt="" width="100">
                    @if ($errors->has('image'))
                        <span class="text-danger">{{$errors->first('image')}}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" @if ($model->status ==1) checked @endif>Enable</option>
                        <option value="0" @if ($model->status ==0) checked @endif>Disable</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Thông tin chi tiết</label>
                    <textarea type="text" class="form-control" id="exampleInputName" placeholder="Nhập thông tin chi tiết" name="description">{{ old('description',$model->description) }}</textarea>
                    @if ($errors->has('description'))
                        <span class="text-danger">{{$errors->first('description')}}</span>
                    @endif
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-dark rounded-pill shadow-lg">LƯU</button>
                    <a href="{{route('cate.index')}}" class="btn btn-danger rounded-pill shadow">HỦY</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection