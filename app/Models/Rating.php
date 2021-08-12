<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Rating extends Model
{
    use HasFactory, Sortable,SoftDeletes;

    protected $table='ratings';
    protected $fillable = ['rating','body','status','user_id','rateable_id'];
    public $sortable = ['id', 'rating', 'body','status','user_id','rateable_id','created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book(){
        return $this->belongsTo(Book::class, 'rateable_id', 'id');
    }

    public function order(){
        return $this->belongsTo(Order::class, 'user_id', 'id_user');
    }
}
