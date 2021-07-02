<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Author extends Model
{
    use HasFactory;
    protected $table='authors';
    protected $fillable = ['name','avatar','description','date_birth'];

    public function books(){
        return $this->belongsToMany(
            Book::class, 
            'author_books', 
            'author_id', 
            'book_id'
        );
    }
}
