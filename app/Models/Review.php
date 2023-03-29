<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $table = 'reviews';


    protected $casts = [
        'supplier_id'   => 'int',
        'user_id'    => 'int',
        'rating'     => 'float',
        'is_reviewed' => 'bool',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'supplier_id',
        'service_id',
        'order_id',
        'rating',
        'review',
        'is_reviewed'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }

    public function supplier()
    {
        return $this->belongsTo(User::class,'supplier_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
