<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSubscriptionRequest extends FormRequest
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
        if ($routeName == 'front.dashboard.subscription.payment') {
            $rules = $this->validateSubscriptionPaymentRequest();
        }

        if ($routeName == 'api.auth.subscription.payment-response') {
            $rules = $this->validateApiSubscriptionPaymentRequest();
        }
        return $rules;
    }

    public function validateSubscriptionPaymentRequest()
    {
        $rules = collect([
            'package_id' => 'required|exists:subscription_packages,id',
        ]);
        return $rules->toArray();
    }

    public function validateApiSubscriptionPaymentRequest()
    {
        $rules = collect([
            'package_id' => 'required|exists:subscription_packages,id',
            'subscription_type' => 'required',
        ]);

        if ($this->get('subscription_type', 'supplier') !== 'free') {
            $rules = $rules->merge([
                "paymentId" => 'required',
                "token" => 'required',
                "PayerID" => 'required'
            ]);
        }
        return $rules->toArray();
    }


    public function attributes()
    {
        return trans('validation')['attributes'];
    }


}
