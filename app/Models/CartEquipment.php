<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartEquipment extends Model
{
  
    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $table = 'carts_equipments';
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
    ];
    protected $fillable = [
        'cart_id',
        'equipment_id',
        'price',
        'quantity',
        'total',
    ];

    public function equipment(){
        return $this->belongsTo(Equipment::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function store()
    {
        return $this->belongsTO(User::class, 'store_id');
    }
    public function getExtrasAttribute($extras){
        return json_decode($extras);
    }
    public function getImagesAttribute($images){
        if(empty($images)){
            $images='images/product.jpg';
        }
        return url($images);
    }

}
