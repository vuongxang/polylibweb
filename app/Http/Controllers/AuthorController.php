<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Http\Requests\AuthorEditRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request){
        $pagesize = 10;
        $keyword=$request->keyword;
        
        if($request->page_size) $pagesize = $request->page_size;

        $authors  = Author::sortable()->where('name','like',"%".$keyword."%")->orderBy('created_at','DESC')->paginate($pagesize);
        $authors_trashed = Author::onlyTrashed()->paginate(10);
        return view('admin.authors.index',compact('authors','keyword','pagesize','authors_trashed'));
    }

    public function trashList(){
        $authors = Author::paginate(10);
        $authors_trashed = Author::onlyTrashed()->paginate(10);
        return view('admin.authors.trash-list',compact('authors','authors_trashed'));
    }

    public function restore($id){
        Author::withTrashed()->where('id', $id)->restore();
        return redirect(route('author.trashlist'))->with('message','Khôi phục thành công')
                                                    ->with('alert-class','alert-success');
    }

    public function forceDelete($id){
      
        $model = Author::withTrashed()->find($id);
        if($model){
            $model = Author::withTrashed()->where('id', $id)->forceDelete();
            return redirect(route('author.trashlist'))->with('message','Xóa tác giả thành công !')
                                                        ->with('alert-class','alert-success');         
        }else{
            return redirect(route('author.trashlist'))->with('message','Dữ liệu không tồn tại !')
                                                        ->with('alert-class','alert-danger');
        }
    }

    public function create(){
        return view('admin.authors.add-form');
    }

    public function store(AuthorRequest $request){
        // $this->validate($request, ['avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        $model = new Author();
        $model->fill($request->all());
        // dd($request->avatar);
        $model->save();
        
        return redirect(route('author.index'));
    }

    public function edit($id){
        $model = Author::find($id);
        if(!$model) return redirect(route('author.index'));
        return view('admin.authors.edit-form', ['model' => $model]);
    }

    public function update($id,AuthorEditRequest $request){
        
        $model = Author::find($id);
        // dd($model->name);
        $model->fill($request->all());
        $model->save();
        return redirect(route('author.index'));
    }

    public function destroy($id){
        $model = Author::find($id);
        if($model){
            Author::where('id',$id)->delete();
            return redirect(route('author.index'))->with('message','Đã di chuyển vào thùng !')
                                                    ->with('alert-class','alert-success');
        }else{
            return redirect(route('author.index'))->with('message','Dữ liệu không tồn tại !')
                                                    ->with('alert-class','alert-danger');
        }
    }

    // public function changePageSize(Request $request){
    //     $keyword=$request->keyword;
    //     $pagesize = $request->pagesize;
    //     $authors  = Author::sortable()->where('name','like',"%".$keyword."%")->paginate($pagesize);

    //     // return response()->json(['authors'=>$authors,'success'=>'Author pagesize change successfully!']);
    // }
    public function authorDetail($id){

        $author = Author::find($id);

        if (!$author) return  abort(404);;
        $author->load('books');
        
        $books = Book::whereHas('authors', function ($query) use ($id) {
            $query->where('id', $id);
        })->where('status', 1)->paginate(9);
        return view('client.pages.author-detail', compact('author','books'));
    }

}
