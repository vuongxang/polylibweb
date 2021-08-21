<?php

namespace App\Http\Controllers;

use App\Models\PostShareCategory;
use Illuminate\Http\Request;

class PostShareCategoryController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 10;
        $keyword=$request->keyword;
        if($request->page_size) $pagesize = $request->page_size;

        $cates  = PostShareCategory::sortable()->where('name','like',"%".$keyword."%")
                                    ->orderBy('created_at','DESC')->paginate($pagesize);
        $cates->load('posts');

        return view('admin.post-cates.index',compact('cates','pagesize'));
    }

    public function create(){
        return view('admin.post-cates.add-form');
    }

    public function store(Request $request){
        $model = new PostShareCategory();
        $model->fill($request->all());
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->name, '-');
        $model->save();
        return redirect(route('postCate.index'))->with('message','Tạo mới thành công !')
                                            ->with('alert-class','alert-success');
    }

    public function edit($id){
        $model = PostShareCategory::find($id);
        if(!$model) return redirect(route('postCate.index'));
        return view('admin.post-cates.edit-form', ['model' => $model]);
    }

    public function update($id,Request $request){
        $model = PostShareCategory::find($id);
        if(!$model) return back();
        $model->fill($request->all());
        $milliseconds = round(microtime(true) * 1000);
        $model->slug = $milliseconds . "-" . str_slug($request->name, '-');
        $model->save();
        return redirect(route('cate.index'))->with('message','Cập nhật thành công !')
                                            ->with('alert-class','alert-success');;
    }

    public function destroy($id){
        $model = PostShareCategory::find($id);
        if($model){
            PostShareCategory::destroy($id);
            return redirect(route('postCate.index'))->with('message','Chuyển vào thùng rác thành công !')
                                                ->with('alert-class','alert-success');
        }else{
            return redirect(route('postCate.index'))->with('message','Dữ liệu không tồn tại !')
                                                ->with('alert-class','alert-danger');;
        }
    }

    public function changeStatus(Request $request){
        $model = PostShareCategory::find($request->id);
        $model->status = $request->status;
        $model->save();

        return response()->json(['success'=>'Category status change successfully!']);
    }

    public function trashList(){
        $cates = PostShareCategory::onlyTrashed()->paginate(5);
        return view('admin.cates.trash-list',compact('cates'));
    }

    public function restore($id){
        PostShareCategory::withTrashed()->where('id', $id)->restore();
        return redirect(route('postCate.trashlist'))->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = PostShareCategory::withTrashed()->find($id);
        if($model){
            $model = PostShareCategory::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('postCate.trashlist'))->with('message','Xóa danh mục thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('postCate.trashlist'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }
}