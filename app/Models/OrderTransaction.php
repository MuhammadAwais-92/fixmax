<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrderTransaction extends Model
{


    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',

    ];
    protected $fillable = [
        'order_id',
        'payer_email',
        'payer_id',
        'payer_status',
        'payment_method',
        'payment_status',
        'payment_id',
        'charges',
        'currency',
        'paypal_response',
        'transaction_details',
    ];

   



}
