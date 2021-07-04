<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory;
    use Sortable;
    protected $table='categories';
    protected $fillable = ['name','image','slug','status','parent_id','description'];

    public $sortable = ['id', 'name', 'description','status','description','image','created_at', 'updated_at'];

    public function books(){
        return $this->belongsToMany(
            Book::class, 
            'category_books', 
            'cate_id', 
            'book_id'
        );
    }
}
