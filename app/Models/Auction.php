<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $table = 'auction'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'product_id',  // รหัสสินค้าที่เกี่ยวข้อง
        'top_price',   // ราคาสูงสุด
        'winner',      // รหัสผู้ชนะ
    ];

    
}
