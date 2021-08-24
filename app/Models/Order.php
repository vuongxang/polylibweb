<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'orders';
    protected $fillable = ['id_user', 'book_id', 'status'];
    protected $dates = ['deleted_at'];

    public function book()
    {
        return $this->belongsTo(
            Book::class,
            'book_id',
            'id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id'
        );
    }

    public function rate()
    {
        return $this->belongsTo(
            Rating::class,
            'book_id',
            'rateable_id'
        );
    }
}
