<?php


namespace App\Http\Repositories;


use App\Http\Repositories\BaseRepository\Repository;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;

use function request;


class OrderItemsRepository extends Repository
{
    protected $addressRepository;
    public function __construct()
    {
        $this->setModel(new OrderItem());
    }

    public function save( $equipment = null, $order=null)
    {

      return  $this->getQuery()->create([
            'order_id' => $order->id,
            'equipment_id' => $equipment->equipment_id,
            'quantity' => $equipment->quantity,
            'name' => $equipment->name,
            'image' =>  $equipment->image,
            'equipment_model' => $equipment->equipment_model,
            'make' => $equipment->make,          
            'price' =>  $equipment->price,
            'total' => $equipment->quantity*$equipment->price,
            'qty_1' =>  $equipment->qty_1,
            'total_1' =>  $equipment->total_1,
            'qty_2' =>  $equipment->qty_2,
            'total_2' =>  $equipment->total_2,
        ]);

    }
}
