<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class UserWeb extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone_number',
        'first_name',
        'last_name',
        'profile_detail',
        'facebook',
        'instagram',
        'line',
        'profile_img',
        'rating' // เพิ่มคอลัมน์ rating
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // กำหนดให้ rating เป็น JSON
    protected $casts = [
        'rating' => 'array',
    ];
}
