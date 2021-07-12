<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(){
        $authors  = Author::sortable()->paginate(5);
        return view('admin.authors.index',compact('authors'));
    }

    public function create(){
        return view('admin.authors.add-form');
    }

    public function store(Request $request){
        $model = new Author();
        $model->fill($request->all());
        $model->save();
        return redirect(route('author.index'));
    }

    public function edit($id){
        $model = Author::find($id);
        if(!$model) return redirect(route('author.index'));
        return view('admin.authors.edit-form', ['model' => $model]);
    }

    public function update($id,Request $request){
        $model = Author::find($id);
        $model->fill($request->all());
        $model->save();
        return redirect(route('author.index'));
    }

    public function destroy($id){
        Author::destroy($id);
        return redirect(route('author.index'));
    }
}
