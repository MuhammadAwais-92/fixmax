<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Dtos\AddAddressDto;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Requests\AddressRequest;
use Exception;

class AddressesController extends Controller
{
    protected $cityRepository,$addressRepository;
    public function __construct(AddressRepository $addressRepository,CityRepository $cityRepository)
    {
        parent::__construct();
        $this->addressRepository = $addressRepository;
        $this->addressRepository->setFromWeb(true);
        $this->cityRepository = $cityRepository;
        $this->cityRepository->setFromWeb(true);
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }
    public function index()
    {
        $this->breadcrumbTitle = __('Saved Addresses');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Saved Addresses')];
        $this->addressRepository->setPaginate(6);
        $addresses = $this->addressRepository->all();
        $cities= $this->cityRepository->all(true);
        return view(
            'front.dashboard.addresses.manage-addresses',
            [
                'addresses' => $addresses,
                'cities'=>$cities
            ]
        );
    }
    public function create()
    {
        $this->breadcrumbTitle = __('Edit Addresses');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Edit Address')];

        $address = $this->addressRepository->getModel();
        return view(
            'front.dashboard.addresses.edit-address',
            [
                'address' => $address
            ]
        );
    }
    public function edit($id)
    {


        $this->breadcrumbTitle = __('Edit Addresses');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Edit Address')];

        $address = $this->addressRepository->get($id);
        return view('front.dashboard.addresses.edit-address', [
            'address' => $address
        ]);
    }
    function city($id)
    {
        $areas= $this->cityRepository->getAreas($id);
        $html='';
        $html .='<option value="">Choose the City Area</option>';
        if(count($areas)>0)
        {
            foreach($areas as $area)
            {
                $html .='<option value='.$area->id.'>'. translate($area->name) .'</option>';
            }
        }
        return $html; 
    }
    function area($id){
        $area= $this->cityRepository->get($id);
        return $area;
    }
    public function destroy($id)
    {
        try {

            if (!empty($id)) {
                $result = $this->addressRepository->delete($id);

                if (!empty($result)) {

                    return redirect()->back()->with('status', __('Address is Deleted.'));
                }
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
    
    public function store(AddressRequest $request)
    {
      
        $this->addressRepository->save($request);

        if ($request->get('id') ) {
            return redirect()->back()->with('status', __('Address is Updated.'));
        }
        return redirect()->back()->with('status', __('Address is Created.'));
    }
    public function save(AddressRequest $request, $id)
    {
        try {
        
            $addAddresstDto = AddAddressDto::fromRequest($request);
            $this->addressRepository->save($addAddresstDto);
            if ($request->id != null) {
                session()->flash('status', __('Address updated successful.'));
            } else {
                session()->flash('status', __('Address created successful.'));
            }
            return redirect(route('front.dashboard.addresses.index'));
        } catch (\Exception $e) {
            return redirect()->back()->with('err', $e->getMessage())->withInput();
        }
    }
    public function makeDefault(Request $request)
    {
        try {
            $this->addressRepository->makeDefault($request);
            return responseBuilder()->success(__('Address Set Default successfully.'));

        } catch (\Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
    function get($id)
    {
        $address = $this->addressRepository->get($id);
        return $address;
    }
}
