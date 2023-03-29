<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Addresses extends Model
{

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

 

    protected $fillable = [
       'user_phone',
       'address',
       'user_id',
       'latitude',
       'longitude',
       'default_address',
       'address_name',
       'city_id',
       'area_id',
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];
    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }
    public function area()
    {
        return $this->belongsTo(City::class,'area_id');
    }

}
