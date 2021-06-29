<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){
        $cates  = Category::paginate(10);
        return view('admin.cates.index',compact('cates'));
    }

    public function create(){
        return view('admin.cates.add-form');
    }

    public function store(Request $request){
        dd($request->all());
    }

    public function edit($id){
        $model = Category::find($id);
        if(!$model) return redirect(route('cate.index'));
        return view('admin.cates.edit-form', ['model' => $model]);
    }

    public function update($id,Request $request){
        $model = Category::find($id);
        dd($request->all());
        $model->name = $request->name;
        if($request->hasFile('logo')){
            $fileName = uniqid().'_'.$request->logo->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('uploads', $fileName, 'public');
            $model->logo = 'storage/'.$filePath;
        }
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
