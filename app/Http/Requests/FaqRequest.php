<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class FaqRequest extends FormRequest
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

        if ($routeName == 'admin.dashboard.faqs.update') {
            $rules = $this->checkUpdateRequest();
        }

        return $rules;
    }

    public function checkUpdateRequest()
    {
        $rules = [
            'question.en' => 'required|max:190',
            'question.'.config("settings.default_language").'' => 'required|max:190',
            'answer.en' => 'required',
            'answer.'.config("settings.default_language").'' => 'required',

        ];
        return $rules;
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function messages()
    {
      
        return [
            'question.en.required' => __('The Question In English field is required'),
            'question.'.config("settings.default_language").'.required' => __('The Question In '.getLanguage(config("settings.default_language")).' field is required'),
            'answer.en.required' => __('The Answer In English field is required'),
            'answer.'.config("settings.default_language").'.required' =>   __('The Answer In '.getLanguage(config("settings.default_language")).' field is required'),
        ];
    }
}

