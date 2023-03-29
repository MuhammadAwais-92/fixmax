<?php

namespace App\Http\Controllers\Front;



use App\Http\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\CartRequest;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $categoryRepository,$serviceRepository;
    public function __construct(CartRepository $cartRepository, ServiceRepository $serviceRepository)
    {
        parent::__construct();
        $this->cartRepository = $cartRepository;
        $this->cartRepository->setFromWeb(true);
        $this->serviceRepository = $serviceRepository;
        $this->serviceRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }


    public function save(CartRequest $request)
    {
        try {
            $service = $this->serviceRepository->get($request->service_id);
            if(!$service)
            {
                return redirect()->route('front.services')->with('err', __('Service has been deleted'));
            }
            $cart = $this->cartRepository->save($request);
            if ($cart) {
                return redirect()->route('front.cart.checkout', ['service_id' => $cart->service_id]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
   

   
}
