<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'issue_images' => 'array',
    ];
    protected $fillable = [
        'user_id',
        'supplier_id',
        'service_id',
        'issue_type',
        'date',
        'time',
        'visit_fee',
        'issue_images',
        'total',
        'description'
    ];
    protected $appends = [
        'issue_images_url',
    ];
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function equipments()
    {
        return $this->hasMany(CartEquipment::class);
    }
    public function supplier()
    {
        return $this->belongsTO(User::class, 'supplier_id');
    }
    public function getFormattedModel(): Cart
    {
        $cart = $this;
        $cart->date = date('d/m/Y',$this->date);
        return $cart;
    }
    public function getIssueImagesUrlAttribute()
    {
        $images = null;
        if (is_array($this->issue_images)) {
            $images = collect($this->issue_images)->map(function ($image) {
                return url($image);
            });
        }
        return $images;
    }

}
