<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use Kyslik\ColumnSortable\Sortable;

class Book extends Model
{
    use HasFactory;
    use Sortable;

    protected $table='books';
    protected $fillable = ['title','status','description','publish_date_from','image','slug'];
    public $sortable = ['id', 'title', 'description','status','publish_date_from','created_at', 'updated_at'];

    public function categories(){
        return $this->belongsToMany(
            Category::class, 
            'category_books', 
            'book_id', 
            'cate_id'
        );
    }

    public function authors(){
        return $this->belongsToMany(
            Author::class, 
            'author_books', 
            'book_id', 
            'author_id'
        );
    }

    public function bookGalleries(){
        return $this->hasMany(BookGallery::class, 'book_id');
    }

    public function bookAudio(){
        return $this->hasMany(BookAudio::class, 'book_id');
    }
}
