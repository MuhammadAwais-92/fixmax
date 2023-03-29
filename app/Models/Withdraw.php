<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $casts = [
        'user_id'    => 'int',
        'amount'     => 'float',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'method',
        'additional_details',
        'remarks',
        'image',
        'paypal_response'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
}
