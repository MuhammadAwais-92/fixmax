<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
        if ($routeName == 'front.dashboard.service.save' || $routeName == 'api.auth.service.save') {
            $rules = $this->SaveServiceRequest();
        }

        return $rules;
    }

    public function SaveServiceRequest()
    {
        return [

            'category_id' => 'required',
            'name' => 'required|array',
            'name.en' => 'required|string|max:100',
            'name.'.config("settings.default_language").'' => 'required|max:190',
            'min_price' => 'required|min:1|max:999999',
            'max_price' => 'required|gt:min_price|min:1|max:999999',
            'description' => 'required|array',
            // 'discount' => 'integer|min:0|max:99',
            'description.en' => 'required',
            'description.'.config("settings.default_language").'' => 'required',
            'expiry_date' => $this->all()['discount'] > 0 ? 'required|after:today' : '',
            'service_images' => 'required',
            'user_id' => 'required',
        ];
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }

    public function messages()
    {
        return [
            'category_id.required' => __('Category Field is required'),
            'name.en.required' => __('Name in english required.'),
            'name.'.config("settings.default_language").'.required'  => __('Name in '.getLanguage(config("settings.default_language")).' required.'),
            'description.en.required' => __('Description in english required.'),
            'description.'.config("settings.default_language").'.required' => __('Description in '.getLanguage(config("settings.default_language")).' required.'),
        ];
    }
}
