<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorBooks extends Model
{
    use HasFactory;
    protected $table='author_books';
    protected $fillable = ['book_id','author_id'];

    public $timestamps = false;
}
