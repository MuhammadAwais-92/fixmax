<?php


namespace App\Http\Repositories;

use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Cart;
use App\Models\CartEquipment;
use Exception;
use App\Http\Repositories\CartEquipmentRepository;
use App\Http\Repositories\ServiceRepository;
use Illuminate\Support\Facades\DB;
use App\Http\Libraries\DataTable;
use Carbon\Carbon;
use Facade\Ignition\QueryRecorder\Query;

class CartRepository extends Repository
{
    protected $cartEquipmentRepository, $serviceRepository;
    public function __construct()
    {
        $this->setModel(new Cart());
        $this->cartEquipmentRepository = new CartEquipmentRepository;
        $this->serviceRepository = new ServiceRepository;
    }
    public function save($request)
    {

        DB::beginTransaction();
        try {
            $data = $request->except(['_token', 'equipment']);
            $this->serviceRepository->setRelations([
                'supplier',
                'images:id,file_path,file_default,file_type,service_id',
            ]);
            $service = $this->serviceRepository->get($data['service_id']);
            $data['user_id'] = $this->getUser()->id;
            $data['supplier_id'] = $service->supplier->id;
    
         
            $date=date('m/d/Y', strtotime(str_replace('/', '-', $data['date'])));
            $data['date'] = DateToUnixformat($date);
            $data['visit_fee'] = $service->supplier->visit_fee;
            if ($data['issue_type'] == 'know') {
                $existData = $this->getModel()->where('user_id', $data['user_id'])->where('service_id', $service->id)->where('issue_type', 'not know')->first();
                if ($existData) {
                    $existData->delete();
                }
                $data['total'] = 0;
                $cart = $this->getModel()->updateOrCreate(['id' => $request->id], $data);
                foreach ($request->equipment as $equipment) {
                    $equipment['cart_id'] = $cart->id;
                    $savedEquipment = $this->cartEquipmentRepository->save($equipment);
                    $cart['total'] = $cart['total'] + $savedEquipment->total;
                }
                $cart->save();
            } else {
                $existData = $this->getModel()->where('user_id', $data['user_id'])->where('service_id', $service->id)->where('issue_type', 'know')->first();
                if ($existData) {
                    $this->cartEquipmentRepository->getModel()->where('cart_id', $existData->id)->delete();
                    $existData->delete();
                }
                $data['total'] = $data['visit_fee'];
                $cart = $this->getModel()->updateOrCreate(['id' => $request->id], $data);
            }
            DB::commit();
            return $cart;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }
    public function get($userId, $serviceId)
    {
        $query = $this->getModel()->query();
        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }
        if (!is_null($serviceId)) {
            $query->where('service_id', $serviceId);
        }
        $cart = $query->select($this->getSelect())->with($this->getRelations())->first();
        return $cart;
    }
    public function getCheckoutContent($serviceId)
    {

        $user = $this->getUser();
        $cart = $this->get($user->id, $serviceId);
        if ($cart->issue_type == 'know') {
            $cart->subTotal = $cart->total + $cart->visit_fee;
            $cart->visit_fee = $cart->visit_fee;
            if ($this->getFromWeb()) {
                $cart->date = date('m/d/Y', $cart->date);
            }

            $cart->vatPercentage = config('settings.value_added_tax');
            $cart->vat = $cart->subTotal * (config('settings.value_added_tax') / 100);
            $cart->grandtotal = $cart->subTotal + $cart->vat;
        } else {
            $cart->subTotal = $cart->total;
            if ($this->getFromWeb()) {
                $cart->date = date('m/d/Y', $cart->date);
            }
            $cart->vatPercentage = config('settings.value_added_tax');
            $cart->vat = $cart->subTotal * (config('settings.value_added_tax') / 100);
            $cart->grandtotal = $cart->subTotal + $cart->vat;
        }
        return $cart;
    }

    public function delete($userId, $serviceId)
    {
        $cart = $this->get($userId, $serviceId);
        $cart->equipments()->delete();
        $cart->delete();
        if ($cart) {
            return true;
        }
        return false;
    }
}
