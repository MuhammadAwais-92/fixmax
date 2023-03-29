<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'parent_id',
        'name->en',
        'name->ar', 
        'polygon', 
        'latitude', 
        'longitude'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',
        'polygon' => 'array'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function coveredAreas()
    {
        return $this->belongsToMany(User::class, 'user_areas');
    }
    public function areas(){
        return $this->hasMany(City::class, 'parent_id');
    }
}
