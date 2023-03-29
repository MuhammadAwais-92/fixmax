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

    }



}
