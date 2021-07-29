<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Rating extends Model
{
    use HasFactory, Sortable;

    protected $table='ratings';
    protected $fillable = ['rating','body','user_id','rateable_id'];
    public $sortable = ['id', 'rating', 'body','user_id','rateable_id','created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
