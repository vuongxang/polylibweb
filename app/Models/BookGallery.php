<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGallery extends Model
{
    use HasFactory;
    protected $table='book_galleries';
    protected $fillable = ['book_id','url'];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id');
    }
}
