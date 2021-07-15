<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, Sortable,SoftDeletes;

    protected $table='comments';
    protected $fillable = ['user_id', 'book_id', 'parent_id', 'body'];
    public $sortable = ['id', 'user_id', 'post_id','parent_id','body','created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
