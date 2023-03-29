<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $table = 'project_images';
    protected $appends = ['image_url'];
    protected $fillable = [
        'project_id',
        'file_path',
        'file_default',
        'file_type',
    ];

    protected $casts = [
        'project_id' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int',
        'file_default' => 'int'
    ];



    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['file_path'])) {
            return url('assets/front/img/Placeholders/stadiumdetail.jpg');
        }
        return url($this->attributes['file_path']);
    }
    public function service()
    {
        return $this->belongsTo(Project::class);
    }

    public function getFormattedModel(): ProjectImage
    {
        $projectImage = $this;
        unset($projectImage->created_at);
        unset($projectImage->updated_at);
        unset($projectImage->deleted_at);
        return $projectImage;
    }
}
