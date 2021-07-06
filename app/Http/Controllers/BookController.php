<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\AuthorBooks;
use App\Models\Book;
use App\Models\BookGallery;
use App\Models\Category;
use App\Models\CategoryBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index(){
        $books = Book::sortable()->paginate(5);
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
        
        return redirect(route('book.index'))->with('message','Thêm mới sách thành công !');
    }

    public function edit($id){
        $model = Book::find($id);
        $cates = Category::all();
        $authors = Author::all();

        if(!$model) return redirect(route('book.index'));
        return view('admin.books.edit-form', ['model' => $model,'cates' => $cates,'authors' => $authors,]);
    }

    public function update($id,Request $request){
        $model = Book::find($id);
        $model->fill($request->all());
        // dd($request->all());
        $model->slug =str_slug($request->title, '-');
        $model->save();
 
        CategoryBook::where('book_id',$model->id)->delete();
        AuthorBooks::where('book_id',$model->id)->delete();

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
                $item1 =[
                    'author_id'=> $author_id,
                    'book_id'=> $model->id
                ];
                DB::table('author_books')->insert($item1);
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
        
        return redirect(route('book.index'))->with('message','Cập nhật thành công !');
    }

    public function destroy($id){
        BookGallery::where('book_id', $id)->delete();
        Book::destroy($id);
        return redirect(route('book.index'))->with('message','Xóa thành công');
    }

    public function changeStatus(Request $request){
        $model = Book::find($request->id);
        $model->status = $request->status;
        $model->save();
  
        return response()->json(['success'=>'Book status change successfully!']);
    }
}
