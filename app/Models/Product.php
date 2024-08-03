<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        'date',
        'time',
        'selection_group',
        'selection_district',
        'payment_methods',
        'username',
        'file_path_1',
        'file_path_2',
        'file_path_3',
        'file_path_4',
        'file_path_5',
        'user_id',
    ];

    protected $casts = [
        'payment_methods' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(UserWeb::class, 'id_user', 'id');
    }


}
