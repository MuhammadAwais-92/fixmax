<?php

namespace App\Http\Controllers\Front;



use App\Http\Repositories\CategoryRepository;
use App\Http\Controllers\Controller;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Dtos\AddAddressDto;
use App\Http\Repositories\CheckoutRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public $categoryRepository, $addressRepository, $checkoutRepository, $serviceRepository, $couponRepository;
    public function __construct(ServiceRepository $serviceRepository, CouponRepository $couponRepository, CartRepository $cartRepository, AddressRepository $addressRepository, CheckoutRepository $checkoutRepository)
    {
        parent::__construct();
        $this->cartRepository = $cartRepository;
        $this->cartRepository->setFromWeb(true);
        $this->addressRepository = $addressRepository;
        $this->addressRepository->setFromWeb(true);
        $this->checkoutRepository = $checkoutRepository;
        $this->checkoutRepository->setFromWeb(true);
        $this->serviceRepository = $serviceRepository;
        $this->serviceRepository->setFromWeb(true);
        $this->couponRepository = $couponRepository;
        $this->couponRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }


    public function index(Request $request)
    {
        $this->breadcrumbTitle = __('Checkout');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Checkout')];
        $this->cartRepository->setRelations([
            'service',
            'user',
            'user.addresses',
            'service.images',
            'equipments',
            'equipments.equipment'

        ]);
        $checkout = $this->cartRepository->getCheckoutContent($request->service_id);
        $ids = $checkout->service->supplier->coveredareas->pluck('id')->toArray();
        if (!in_array(session()->get('area_id'), $ids)) {
            session()->put('area_id', null);
        }
        if (!session()->get('area_id')) {
            return redirect()->route('front.service.detail', $checkout->service->slug);
        }
        $check=false;
        if(session()->get('area_id'))
        {
            $addresses = $this->addressRepository->allCurrentAddresses(session()->get('area_id'));
            if($addresses->isEmpty())
            {
                $check=true;
            }
        }
        return view('front.checkout.checkout', ['cartContent' => $checkout,'check' => $check]);
    }
    public function save(CheckoutRequest $request)
    {

        try {
            if ($request->checkout == 'first') {
                $service = $this->serviceRepository->get($request->service_id);
                if (!$service) {
                    return redirect()->route('front.services')->with('err', __('Service has been deleted'));
                }
                $response = $this->checkoutRepository->save($request);
                if ($response) {
                    return redirect()->route('front.dashboard.quotations.index', ['status' => 'pending'])->with('status', __('Quotation Request sent successfully.'));
                } else {
                    return redirect()->back()->with('err', __('Something went Wrong.'));
                }
            } else {
                $response = $this->checkoutRepository->save($request);
                if ($response) {
                    return redirect()->route('front.dashboard.orders.index', ['status' => 'confirmed'])->with('status', __('Order Placed Successfully'));
                } else {
                    return redirect()->back()->with('err', __('Something went Wrong.'));
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function getAddresses($id)
    {
        
        try {
            $addresses = $this->addressRepository->allCurrentAddresses($id);
            $defaultAddress = '';
            if ($addresses->isNotEmpty()) {
                $defaultAddress = $addresses->where('default_address', '1')->first();
            }

            $data = '';
            $data = '<form id="getAddress"><div class="modal-desc px-1">';
            foreach ($addresses as $address) {
                $check = '';
                if ($address->default_address == '1') {
                    $check = 'checked';
                }

                $data .= ' <div class="role-radio">
             <label class="custom-radio">
                      ' . $address->address . ' 
                 <input type="radio"  name="id" value="' . $address->id . '" ' . $check . '>
                 <span class="checkmark"></span>
             </label>
         </div>';
            }
            $data .= '<button  class="login-btn w-100">
        Submit
    </button>
</div></form>';
            return response(['status_code' => '200', 'data' =>  $data, 'defaultAddress' => $defaultAddress]);
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function getAddressAjax(Request $request)
    {
        try {
            $res = $this->addressRepository->makeDefault($request);
            $address = $this->addressRepository->get($request->id);
            $data = '  <div class="my-title d-flex justify-content-between align-items-center flex-wrap">
       <h3>
         '.__("Address").'
       </h3>
       <div id="getAddressesModal" class="add-desc pt-0 d-flex gap-15">
                            <a href="#" data-toggle="modal" data-target="#get-addresses-modal" class="link-btn">
                                '.__("Change Address").'
                            </a>
                            <a  href="#" data-toggle="modal"   data-target="#addressModal" id="address-modal" class="link-btn link-btns">
                                '.__("Add New Address").'
                            </a>
                        </div>
       
     </div>              
     <div class="add-desc">
       <div class="d-flex flex-wrap justify-content-between align-content-center mb-1">
         <h6 class="prim-title mb-0">
           ' . $address->address_name . '
         </h6>
         <input type="hidden" id="idAddress" name="id" value="' . $address->id . '"></input>
         <div class="edit-del-btnz-block d-flex align-items-center">                        
           <button data-toggle="modal"  data-target="#addressModal" value="' . $address->id . '" class="edit-del-btn edit-address link-btns">
             <i class="fas fa-edit"></i>
           </button>
           <span class="seprater"></span>
           <button  class="deleteAddress edit-del-btn"  data-id="' . $address->id . '">
             <i class="fas fa-trash-alt"></i>
           </button>
         </div>
       </div>                
       <p class="prime-title-l">
       ' . $address->address . '
       </p>
       <a href="tel: ' . $address->user_phone . '" dir="ltr" class="prime-title-l">
       ' . $address->user_phone . '
       </a>                
     </div>';
            return response(['status_code' => '200', 'data' =>  $data, 'address' => $address]);
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function saveAddress(Request $request)
    {
        try {
            $addAddresstDto = AddAddressDto::fromRequest($request);
            $response = $this->addressRepository->save($addAddresstDto);
            $res = $this->addressRepository->makeDefault($request);

            return response(['status_code' => '200', 'id' =>  $response->id]);
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }

    public function removeCoupon()
    {
        try {
            $result = $this->couponRepository->destroy(null);
            if (!empty($result)) {
                return redirect()->back()->with('status', "Coupon is Successfully Removed.");
            }
            return redirect()->back()->with('status', "Something goes wrong.");
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
}
