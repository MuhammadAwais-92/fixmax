<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        if ($routeName == 'admin.dashboard.pages.update' || $routeName == 'admin.dashboard.offers.update') {
            $rules = $this->validatePageUpdateRequest();
        }
        return $rules;
    }

    public function validatePageUpdateRequest()
    {
        $rules = collect([
            'name' => 'array|required',
            'name.en' => 'required',
            'name.'.config("settings.default_language").'' => 'required',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.'.config("settings.default_language").'' => 'required',
            'page_id' => 'required',
//            'image' => 'sometimes',
        ]);

        return $rules->toArray();
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


}
