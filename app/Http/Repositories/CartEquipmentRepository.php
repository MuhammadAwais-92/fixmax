<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Cart;
use App\Models\CartEquipment;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Http\Libraries\DataTable;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;

class CartEquipmentRepository extends Repository
{ 

protected $equipmentRepository;
    public function __construct()
    {
        $this->setModel(new CartEquipment());
        $this->equipmentRepository=new EquipmentRepository();

    }
    public function save($equipment)
    {
        $cartEquipment=$this->getModel()->where('cart_id',$equipment['cart_id'])->where('equipment_id',$equipment['equipment_id'])->first();
        if($cartEquipment)
        {
           $this->getModel()->where('cart_id',$equipment['cart_id'])->delete();
        }
         $price= $this->equipmentRepository->get($equipment['equipment_id'])->price;
         $equipment['price']=$price;
         $equipment['total']=$equipment['quantity']*$price;
         $saveEquipment = $this->getModel()->create($equipment);
         return $saveEquipment;
    }
    
}
