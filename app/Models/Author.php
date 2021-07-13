<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, Sortable,SoftDeletes;

    protected $table='authors';
    protected $fillable = ['name','avatar','description','date_birth'];
    public $sortable = ['id', 'name', 'avatar','description','date_birth','created_at', 'updated_at'];

    public function books(){
        return $this->belongsToMany(
            Book::class,
            'author_books',
            'author_id',
            'book_id'
        );
    }
}
