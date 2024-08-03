<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartWishList extends Model
{
    protected $table = 'cart_wish_list';
    protected $fillable = ['id_user', 'cart_product_ids', 'cart_product_quantities', 'wish_list_product_ids', 'add_cart_date', 'add_wish_list_date'];
    public $timestamps = false;

    protected $casts = [
        'cart_product_ids' => 'array',
        'cart_product_quantities' => 'array',
        'wish_list_product_ids' => 'array',
        'add_cart_date' => 'array',
        'add_wish_list_date' => 'array',
    ];
}
