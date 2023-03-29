<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrderItem extends Model
{


    protected $dateFormat = 'U';
    public static $snakeAttributes = false;
    protected $casts = [
        'created_at' => 'int',
        'updated_at' => 'int',
        'name' => 'array',

    ];
    protected $fillable = [
        'order_id',
        'equipment_id',
        'price',
        'quantity',
        'total',
        'name',
        'image',
        'equipment_model',
        'make',
        'qty_1',
        'total_1',
        'qty_2',
        'total_2',
    ];
    public function equipment(){
        return $this->belongsTo(Equipment::class);
    }
   



}
