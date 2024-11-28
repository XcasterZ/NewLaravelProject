<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_web_id', // เปลี่ยนจาก user_id เป็น user_web_id
        'bank_name',
        'account_number',
        'account_name', 
        'truewallet_phone',
        'qr_image',
    ];

    // เปลี่ยนความสัมพันธ์เป็น UserWeb
    public function userWeb()
    {
        return $this->belongsTo(UserWeb::class);
    }
}
