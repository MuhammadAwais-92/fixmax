<?php


namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
     'updated_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'question' => 'array',
        'answer' => 'array',
    ];

    protected $fillable = [
        'question',
        'answer',
    ];
}
