<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    use HasFactory;

    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $table = 'service_images';

    protected $fillable = [
        'service_id',
        'file_path',
        'file_default',
        'file_type',
    ];

    protected $casts = [
        'service_id' => 'int',
        'created_at' => 'int',
        'updated_at' => 'int',
        'file_default' => 'int'
    ];





    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function getFormattedModel(): ServiceImage
    {
        $stadiumImage = $this;
        unset($stadiumImage->created_at);
        unset($stadiumImage->updated_at);
        unset($stadiumImage->deleted_at);
        return $stadiumImage;
    }
}
