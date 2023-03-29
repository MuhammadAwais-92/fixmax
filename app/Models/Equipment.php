<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Equipment extends Model
{
    use SoftDeletes;
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;

    protected $table = 'equipments';
    protected $appends = [
        'image_url'
    ];
    protected $fillable = [
        'user_id',
        'service_id',
        'name',
        'image',
        'price',
        'equipment_model',
        'make',
    ];
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',
    ];
    public function getImageUrlAttribute()
    {
        if (empty($this->attributes['image'])) {
            return url('images/default-image.jpg');
        }
        return url($this->attributes['image']);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function supplier()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function getFormattedModel(): Equipment
    {
        $equipment = $this;
        unset($equipment->created_at);
        unset($equipment->updated_at);
        unset($equipment->deleted_at);
        return $equipment;
    }
}
