<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';

    public static $snakeAttributes = false;

    protected $casts = [
        'name'          => 'array',
        'coupon_code'   => 'string',
        'discount'      => 'int',
        'status'        => 'string',
        'coupon_type'   => 'string',
        'coupon_number' => 'int',
    ];

    protected $fillable = [
        'name->ar',
        'name->en',
        'coupon_code',
        'discount',
        'end_date',
        'status',
        'coupon_type',
        'coupon_number',
    ];
}
