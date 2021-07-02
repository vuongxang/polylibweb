<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Category extends Model
{
    use HasFactory;
    protected $table='categories';
    protected $fillable = ['name','image','slug','status','parent_id','description'];

    public function books(){
        return $this->belongsToMany(
            Book::class, 
            'category_books', 
            'cate_id', 
            'book_id'
        );
    }
}
