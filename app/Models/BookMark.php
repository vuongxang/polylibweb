<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    use HasFactory;
    protected $table = "bookmarks";
    protected $fillable = ['book_id', 'user_id', 'page', 'content'];
    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id',
            'id'
        );
    }
    public function bookGallery()
    {
        return $this->hasOne(
            BookGallery::class,
            'id',
            'page'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }
}
