<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
        'updated_at', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',
        'description' => 'array',
    ];
    protected $fillable = [
        'id',
        'name',
        'duration',
        'duration_type',
        'price',
        'description',
        'subscription_type',

    ];

    public function isForSupplier(){
        return $this->attributes['subscription_type'] == 'supplier';
    }

    public function isForOffer(){
        return $this->attributes['subscription_type'] == 'offer';
    }
    public function isFree(){
        return $this->attributes['subscription_type'] == 'free';
    }
    public function isFeatured(){
        return $this->attributes['subscription_type'] == 'featured';
    }

}
