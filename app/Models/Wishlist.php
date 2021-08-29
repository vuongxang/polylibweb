<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table='wishlists';
    
    public function post(){
        return $this->belongsTo(
            PostShare::class, 
            'post_id', 
            'id'
        );
    }

    public function user(){
        return $this->belongsTo(
            User::class, 
            'user_id', 
            'id'
        );
    }
}
