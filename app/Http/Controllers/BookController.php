<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books = Book::paginate(10);
        $books->load('categories');
        $books->load('authors');
        $books->load('bookGalleries');
        $books->load('bookAudio');

        return view('admin.books.index',compact('books'));
    }

    public function create(){
        $cates = Category::all();
        $authors = Author::all();
        return view('admin.books.add-form',compact('cates','authors'));
    }

    public function store(Request $request){
        $model = new Book();
        
        $model->fill($request->all());
        // dd($request->all());
        $model->slug =str_slug($request->title, '-');
        $model->save();

        if($request->cate_id){
            foreach($request->cate_id as $cate_id){
                $item =[
                    'cate_id'=> $cate_id,
                    'book_id'=> $model->id
                ];
                DB::table('category_books')->insert($item);
            }
        }

        if($request->author_id){
            foreach($request->author_id as $author_id){
                $item =[
                    'author_id'=> $author_id,
                    'book_id'=> $model->id
                ];
                DB::table('author_books')->insert($item);
            }
        }

        if($request->list_image){
            $list_image = json_decode($request->list_image);
            foreach($list_image as $url){
                $item =[
                    'book_id'=> $model->id,
                    'url'=> $url,
                ];
                DB::table('book_galleries')->insert($item);
            }
        }
        
        return redirect(route('book.index'));
    }

    public function edit($id){
        $model = Book::find($id);
        dd($model);
        if(!$model) return redirect(route('book.index'));
        return view('admin.books.edit-form', ['model' => $model]);
    }

    public function update($id,Request $request){
        $model = Book::find($id);
        $model->fill($request->all());
        $model->slug =str_slug($request->book, '-');
        $model->save();
        return redirect(route('cate.index'));
    }

    public function destroy($id){
        Book::destroy($id);
        return redirect(route('book.index'));
    }

    public function changeStatus(Request $request){
        $model = Book::find($request->id);
        $model->status = $request->status;
        $model->save();
  
        return response()->json(['success'=>'Book status change successfully!']);
    }
}
