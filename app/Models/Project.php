<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    //    use HasFactory;
    protected $table = 'projects';
    protected $appends = ['default_image','image_url'];

    protected $fillable = [
        'name',
        'user_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',
        'description' => 'array'
    ];

    public function getDateFormat()
    {
        return 'U';
    }


    public function getDefaultImageAttribute()
    {
        $default_image = $this->images()->where('project_id', $this->id)->where('file_default', 1)->get()->first();
        if (!is_null($default_image)) {
            return url($default_image->file_path);
        }
        return url('assets/front/img/Placeholders/service.jpg');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('file_default', 'desc');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


  
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image'])) {
            return url('images/default-image.jpg');
        }
        return url($this->attributes['image']);
    }


    public function getFormattedModel(): Project
    {
        $project = $this;
        unset($project->created_at);
        unset($project->updated_at);
        unset($project->deleted_at);
        return $project;
    }
}
