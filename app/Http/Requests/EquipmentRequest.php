<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
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
        if ($routeName == 'front.dashboard.equipment.save' || $routeName == 'api.auth.equipment.save') {
            $rules = $this->SaveEquipmentRequest();
        }

        return $rules;
    }

    public function SaveEquipmentRequest()
    {
        return [

            'service_id' => 'required',
            'name' => 'required|array',
            'name.en' => 'required|string|max:100',
            'name.'.config("settings.default_language").'' => 'required|string|max:100',
            'price' => 'required|min:1|max:999999',
            'image' => 'required',
            'equipment_model' => 'required',
            'make' => 'required|integer|between:1990,2099',
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
            'service_id.required' => __('Service Field is required'),
            'name.en.required' => __('Name in english required.'),
            'name.'.config("settings.default_language").'.required' => __('Name In '.getLanguage(config("settings.default_language")).' is required'),
            'description.en.required' => __('Description in english required.'),
            'description.ar.required' => __('Description in arabic required.'),
        ];
    }


}
