<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class UserArea extends Model
{

    protected $dateFormat = 'U';


    protected $fillable = [
        'user_id',
        'city_id',
        'estimated_time',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function area()
    {
        return $this->belongsTo(\App\Models\City::class,'city_id','id');
    }
    
}
