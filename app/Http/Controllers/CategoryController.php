<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Book;


class CategoryController extends Controller
{

    public function show(){
        $data=Book::paginate(6);
        return view('client.pages.category',['cate'=>$data]);
    }
    public function index(){
        $cates  = Category::sortable()->paginate(5);
        return view('admin.cates.index',compact('cates'));
    }

    public function create(){
        return view('admin.cates.add-form');
    }

    public function store(Request $request){
        $model = new Category();
        $model->fill($request->all());
        $model->slug =str_slug($request->name, '-');
        $model->save();
        return redirect(route('cate.index'));
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
        return redirect(route('cate.index'));
    }

    public function destroy($id){
        Category::destroy($id);
        return redirect(route('cate.index'));
    }
    
    public function changeStatus(Request $request){
        $model = Category::find($request->id);
        $model->status = $request->status;
        $model->save();
  
        return response()->json(['success'=>'Category status change successfully!']);
    }
}
