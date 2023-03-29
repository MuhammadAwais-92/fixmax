<?php

namespace App\Http\Controllers\Api;



use App\Http\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Dtos\AddAddressDto;
use App\Http\Repositories\CheckoutRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public $categoryRepository, $addressRepository, $checkoutRepository,$couponRepository;
    public function __construct(CartRepository $cartRepository,CouponRepository $couponRepository, AddressRepository $addressRepository, CheckoutRepository $checkoutRepository)
    {
        parent::__construct();
        $this->cartRepository = $cartRepository;
        $this->cartRepository->setFromWeb(false);
        $this->addressRepository = $addressRepository;
        $this->addressRepository->setFromWeb(false);
        $this->checkoutRepository = $checkoutRepository;
        $this->checkoutRepository->setFromWeb(false);
        $this->couponRepository = $couponRepository;
        $this->couponRepository->setFromWeb(false);
    }
    public function index(Request $request)
    {
        $this->cartRepository->setRelations([
            'service',
            'user',
            'user.addresses',
            'service.images',
            'equipments',
            'equipments.equipment'

        ]);
        $checkout = $this->cartRepository->getCheckoutContent($request->service_id);
        if (!empty($checkout)) {
            return responseBuilder()->success(__('Checkout Content'), ['Checkout data' => $checkout]);
        }
        return responseBuilder()->error(__('Checkout data Not Found'));
    }
    public function save(CheckoutRequest $request)
    {
        try {
            if ($request->checkout == 'first') {
                $response = $this->checkoutRepository->save($request);
                if ($response) {
                    return responseBuilder()->success(__('order Saved Successfully'));
                } else {
                    return responseBuilder()->error(__('Something went Wrong.'));
                }
            } else {
                $response = $this->checkoutRepository->save($request);
                if ($response) {
                    return responseBuilder()->success(__('order Saved Successfully'));
                } else {
                    return responseBuilder()->error(__('Something went Wrong.'));
                }
            }
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function removeCoupon()
    {
        try {
            $result = $this->couponRepository->destroy(null);
            if (!empty($result)) {
                return response(['status' => 'Coupon is Successfully Removed.']);
            }
            return response(['err' => 'Something goes wrong.']);
        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
}
