<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoveredAreaRequest extends FormRequest
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
        if ($routeName == 'front.auth.covered.areas') {
            $rules = $this->SaveCoveredAreasRequest();
        }

        return $rules;
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function SaveCoveredAreasRequest()
    {
        return [
            'covered_areas.*.city_id' => 'required|exists:cities,id',
        ];
    }


}
