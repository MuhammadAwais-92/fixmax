<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class GalleryRequest extends FormRequest
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
        $rules = [];
        $routeName = $this->route()->getName();

        if ($routeName == 'admin.dashboard.galleries.update') {
            $rules = $this->checkUpdateRequest();
        }

        return $rules;
    }

    public function checkUpdateRequest()
    {

        $rules = [
            'image' => 'required',
        ];
        return $rules;
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


}

