<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        if ($routeName == 'admin.dashboard.categories.update' || $routeName == 'admin.dashboard.categories.sub-categories.update') {
            $rules = $this->validateUpdateRequest();
        }
        return $rules;
    }

    public function validateUpdateRequest()
    {
        return [
            'name' => 'required|array',
            'name.en' => 'required|string',
            'image' => 'required',
            'name.ar' => 'required|string',
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
