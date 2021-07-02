<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBook extends Model
{
    use HasFactory;
    protected $table='category_books';
    protected $fillable = ['book_id','cate_id'];

    public $timestamps = false;
}
