<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $pagesize = 5;
        $keyword=$request->keyword;
        if($request->page_size) $pagesize = $request->page_size;

        $cates  = Category::sortable()->where('name','like',"%".$keyword."%")->paginate($pagesize);
        $cates->load('books');

        return view('admin.cates.index',compact('cates','pagesize'));
    }

    public function create(){
        return view('admin.cates.add-form');
    }

    public function store(CategoryRequest $request){
        $model = new Category();
        $model->fill($request->all());
        $model->slug =str_slug($request->name, '-');
        $model->save();
        return redirect(route('cate.index'))->with('message','Tạo mới thành công !')
                                            ->with('alert-class','alert-success');
    }

    public function edit($id){
        $model = Category::find($id);
        if(!$model) return redirect(route('cate.index'));
        return view('admin.cates.edit-form', ['model' => $model]);
    }

    public function update($id,Request $request){
        $model = Category::find($id);
        $model->fill($request->all());
        $model->slug =str_slug($request->name, '-');
        $model->save();
        return redirect(route('cate.index'))->with('message','Cập nhật thành công !')
                                            ->with('alert-class','alert-success');;
    }

    public function destroy($id){
        $model = Category::find($id);
        if($model){
            Category::destroy($id);
            return redirect(route('cate.index'))->with('message','Chuyển vào thùng rác thành công !')
                                                ->with('alert-class','alert-success');
        }else{
            return redirect(route('cate.index'))->with('message','Dữ liệu không tồn tại !')
                                                ->with('alert-class','alert-danger');;
        }
    }

    public function changeStatus(Request $request){
        $model = Category::find($request->id);
        $model->status = $request->status;
        $model->save();

        return response()->json(['success'=>'Category status change successfully!']);
    }

    public function trashList(){
        $cates = Category::onlyTrashed()->paginate(5);
        return view('admin.cates.trash-list',compact('cates'));
    }

    public function restore($id){
        Category::withTrashed()->where('id', $id)->restore();
        return redirect(route('cate.trashlist'))->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = Category::withTrashed()->find($id);
        if($model){
            $model = Category::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('cate.trashlist'))->with('message','Xóa danh mục thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('cate.trashlist'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }
}
