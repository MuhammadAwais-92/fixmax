<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionPackageRequest extends FormRequest
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
        if ($routeName == 'admin.dashboard.subscriptions.update') {
            $rules = $this->validateSubscriptionPackageUpdateRequest();
        }
        return $rules;
    }

    public function validateSubscriptionPackageUpdateRequest()
    {
        $rules = collect([
            'name' => 'array|required',
            'name.en' => 'required',
            'name.'.config("settings.default_language").'' => 'required',
            'price' => 'required',
            'duration' => 'required',
            'duration_type' => 'required',
            'description' => 'required|array',
            'description.en' => 'required',
            'description.'.config("settings.default_language").'' => 'required',
            'package_id' => 'required',
        ]);
        return $rules->toArray();
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function messages()
    {
        return [
            'name.en.required' => __('Name In English is required'),
            'name.'.config("settings.default_language").'.required' => __('Name In '.getLanguage(config("settings.default_language")).'  is required'),
            'description.en.required' => __('Description In English is required'),
            'description.'.config("settings.default_language").'.required' =>   __('Description In '.getLanguage(config("settings.default_language")).'  is required'),

        ];
    }

}
