<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostShareCategory extends Model
{
    use HasFactory , Sortable, SoftDeletes;
    protected $table='post_share_categories';
    protected $fillable = ['name','image','slug','status','description'];

    public $sortable = ['id', 'name', 'description','status','description','image','created_at', 'updated_at'];

    public function posts(){
        return $this->belongsToMany(
            PostShare::class, 
            'post_share_category_details', 
            'post_id', 
            'cate_id'
        );
    }
}
