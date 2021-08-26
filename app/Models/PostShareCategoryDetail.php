<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostShareCategoryDetail extends Model
{
    use HasFactory;
    protected $table='post_share_categories';
    protected $fillable = ['post_id','cate_id'];

    public $timestamps = false;
}
