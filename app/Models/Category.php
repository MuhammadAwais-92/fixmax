<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'name->en',
        'name->ar'
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array'
    ];
    protected $appends = [
        'image_url',
    ];
    public function subCategories(){
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image'])) {
            return url('images/default-image.jpg');
        }
        return url($this->attributes['image']);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
