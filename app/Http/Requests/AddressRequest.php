<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $routeName = $this->route()->getName();
        $rules = [];
        if ($routeName == 'front.dashboard.address.store' || $routeName == 'api.auth.address.store') {
            $rules = $this->SaveAddressRequest();
        }

        return $rules;
    }

    public function SaveAddressRequest()
    {
        return [
            'user_id' => 'required',
            'address_name' => 'required|string|max:100',
            'user_phone' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'city_id'=>'required',
            'area_id'=>'required',
        ];
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function messages()
    {
        return [
            'address.required'=>__('please search and add address.'),
            'address_name.required'=>__('Please add Address name.'),
            'building.required'=>__('Please add building no.'),
            'address_description.required'=>__('Please add address description.'),
//            'user_phone.required'=>__('Please enter mobile number.'),
//            'type.required'=>__('please select one address type.'),
            'latitude.required'=>__('required'),
            'longitude.required'=>__('required'),
        ];
    }

}
