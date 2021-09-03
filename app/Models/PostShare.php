<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostShare extends Model
{
    use HasFactory , Sortable, SoftDeletes;
    protected $table='post_shares';
    protected $fillable = ['title','thumbnail','slug','status','content','user_id'];

    public $sortable = ['id', 'title', 'slug','status','content','created_at', 'updated_at'];

    public function cates(){
        return $this->belongsToMany(
            PostShareCategory::class, 
            'post_share_category_details', 
            'post_id', 
            'cate_id'
        );
    }

    public function user(){
        return $this->belongsTo(
            User::class, 'user_id', 'id'
        );
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class, 'post_id');
    }

    public function postFiles(){
        return $this->hasMany(PostFileData::class, 'post_id');
    }

    public function comments(){
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function postViews(){
        return $this->hasMany(PostView::class, 'post_id');
    }
}
