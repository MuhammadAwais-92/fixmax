<?php

namespace App\Http\Controllers\Api;



use App\Http\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CartRepository;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $categoryRepository;
    public function __construct(CartRepository $cartRepository)
    {
        parent::__construct();
        $this->cartRepository = $cartRepository;
        $this->cartRepository->setFromWeb(false);
    }


    public function save(CartRequest $request)
    {
        try {
            
            $cart = $this->cartRepository->save($request);
            if ($cart) {
                return responseBuilder()->success(__('cart save'), ['service_id' => $cart->service_id]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function cartData(CartRequest $request)
    {
        $this->cartRepository->setRelations([
            'service',
            'user',
            'supplier',
            'user.addresses',
            'service.images',
            'equipments',
            'equipments.equipment'
        ]);
        $userData=$this->cartRepository->getCheckoutContent($request->service_id);
        $userData->defaultAddress=$userData->user->addresses->where('default_address','1')->first();
        if($userData)
        {
         $userData->getFormattedModel();
        }
        if (!empty($userData)) {
            return responseBuilder()->success(__('cart'), ['cart data' => $userData]);
        }
        return responseBuilder()->error(__('cart data Not Found'));
    } 
   
}
