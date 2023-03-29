<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        if ($routeName == 'front.dashboard.quotation.visit' || $routeName == 'front.dashboard.quotation.reject' || $routeName == 'api.auth.quotation.visit' || $routeName == 'api.auth.quotation.reject') {
            $rules = $this->validateStatusRequest();
        }
        if ($routeName == 'front.dashboard.quotation.quote' || $routeName == 'api.auth.quotation.quote') {
            $rules = $this->validateQuoteStatusRequest();
        }
        if ($routeName == 'front.dashboard.order.cancel' || $routeName == 'front.dashboard.order.in-progress' || $routeName == 'front.dashboard.order.complete' || $routeName == 'api.auth.order.in-progress' || $routeName == 'api.auth.order.complete' || $routeName == 'api.auth.order.cancel') {
            $rules = $this->validateOrderStatusRequest();
        }
        return $rules;
    }

    public function validateStatusRequest()
    {
        return [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:visited,confirmed,completed,cancelled,quoted,rejected',

        ];
    }

    public function validateOrderStatusRequest()
    {
        return [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:completed,cancelled,in-progress',

        ];
    }

    public function validateQuoteStatusRequest()
    {
        return [
            'id' => 'required|exists:orders,id',
            'status' => 'required|in:visited,confirmed,completed,cancelled,quoted,rejected',
            'quoated_price' => 'required|lte:max_price|gte:min_price',
        ];
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
