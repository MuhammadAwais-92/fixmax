<?php


namespace App\Models;

//use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $hidden = [
     'updated_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'content' => 'array',
        'name' => 'array',
    ];

    protected $fillable = [
        'slug',
        'image',
        'name',
        'content',
        'detail_image',
    ];

    protected $appends = [
        'image_url','detail_image_url'
    ];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->getTimestamp();
    }
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image']))
        {
            return url('images/default-image.jpg');
        }
        return url( $this->attributes['image']);
    }
    public function getDetailImageUrlAttribute()
    {
        if (empty($this->attributes['detail_image']))
        {
            return url('images/default-image.jpg');
        }
        return url( $this->attributes['detail_image']);
    }
}
