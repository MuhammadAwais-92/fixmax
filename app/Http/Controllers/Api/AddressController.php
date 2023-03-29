<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Dtos\AddAddressDto;
use App\Http\Repositories\AddressRepository;
use App\Http\Requests\AddressRequest;

class AddressController extends Controller
{
    protected object  $addressRepository;

    public function __construct( AddressRepository $addressRepository)
    {
        parent::__construct();
    
        $this->addressRepository = $addressRepository;
        $this->addressRepository->setFromWeb(false);
       

    }


    
    public function destroy($id)
    {
        if (!empty($id)) {
            $result = $this->addressRepository->delete($id);
            if (!empty($result)) {
                return responseBuilder()->success(__('Address is Deleted.'));
            }
        }

    }
    public function index()
    {
        $data = $this->addressRepository->all();
        if($data){
            return responseBuilder()->success(__('Addresses'), $data);  
        }else{
            return responseBuilder()->success(__('msg'), 'No address found');  
        }
    }
    public function getAddresses(Request $request)
    {

        $data = $this->addressRepository->allCurrentAddresses($request->id);
        if($data){
            return responseBuilder()->success(__('Addresses'), $data);  
        }else{
            return responseBuilder()->success(__('msg'), 'No address found');  
        }
    }
    public function all(Request $request)
    {
        $this->addressRepository->setPaginate(6);
        $addresses = $this->addressRepository->all();

        if (!empty($addresses)) {
            return responseBuilder()->success(__('addresses'), $addresses);
        }
        return responseBuilder()->error(__('addresses Not Found'));
    }

    public function store(AddressRequest $request)
    {

        $data=$this->addressRepository->save($request);
        
        if (!empty($request->get('id'))) {
            return responseBuilder()->success(__('Address is Updated.'), ['Addresses'=>$data]);  
        }
        return responseBuilder()->success(__('Address is created.'), ['Addresses'=>$data]);  
    }

    public function edit($id)
    {
        $address = $this->addressRepository->get($id);
        if (!empty($address)) {
            return responseBuilder()->success(__('address'), ['address' => $address]);
        }
        return responseBuilder()->error(__('address Not Found'));
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

}
