<?php


namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
     'updated_at'
    ];
    protected $casts = [
        'is_active' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int'
    ];

    protected $fillable = [
        'short_code',
        'is_rtl',
        'title'
    ];

  


}
