<?php


namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
     'updated_at'
    ];
    protected $appends = [
        'image_url'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];

    protected $fillable = [
        'image'
    ];
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image']))
        {
            return url('images/default-image.jpg');
        }
        return url( $this->attributes['image']);
    }
}
