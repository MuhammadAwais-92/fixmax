<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
        if ($routeName == 'admin.dashboard.cities.update') {
            $rules = $this->validateUpdateRequest();
        }
        if ($routeName == 'admin.dashboard.cities.areas.update') {
            $rules = $this->validateUpdateAreaRequest();
        }
        return $rules;
    }

    public function validateUpdateRequest()
    {
        return [
            'name' => 'required|array',
            'name.en' => 'required|string',
            'name.ar' => 'required|string',

        ];
    }

    public function validateUpdateAreaRequest()
    {
        return [
            'name' => 'required|array',
            'name.en' => 'required|string',
            'name.ar' => 'required|string',
            'polygon' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'city_id' => 'required|numeric',
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
