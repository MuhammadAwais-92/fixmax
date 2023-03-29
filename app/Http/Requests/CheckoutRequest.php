<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        if ($routeName == 'front.checkout.cart' || $routeName == 'api.auth.checkout.cart') {
            $rules = $this->validateUpdateRequest();
        }
        return $rules;
    }

    public function validateUpdateRequest()
    {

        if ($this->get('checkout', 'first') == 'first') {
            return [
                'paymentID' => 'required',
                'payerID' => 'required',
                'selected_address' => 'required|exists:addresses,id',
                'payment_method' => 'required',
                'service_id' => 'required',
            ];

        } else {
            return [
                'paymentID' => 'required',
                'payerID' => 'required',
                'selected_address' => 'required|exists:addresses,id',
                'payment_method' => 'required',
                'order_id' => 'required|exists:orders,id',
            ];
        }

    }


    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function messages()
    {
        return [
            'name.en.required' => __('Name In English is required'),
            'name.ar.required' => __('Name In Arabic is required'),
        ];
    }
}
