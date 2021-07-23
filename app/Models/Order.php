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
    protected $dates = ['deleted_at'];

    public function books(){
        return $this->belongsTo(
            Book::class, 'id_book', 'id'
        );
    }

}
