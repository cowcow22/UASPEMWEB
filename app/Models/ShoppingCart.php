<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $fillable = [
        'idUser',
        'idUProduct',
        'qty',
        'totalPrice',
    ];

    use HasFactory;
}
