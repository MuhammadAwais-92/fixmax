<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class ArticleRequest extends FormRequest
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

        if ($routeName == 'admin.dashboard.articles.update') {

            if (request()->get('article_id') == "0") {
                $rules = $this->addNewArticle();
            } else {
                $rules = $this->updateArticle();
            }
        }

        return $rules;
    }

    public function addNewArticle()
    {
        $rules = [
            'name' => 'required|array',
            'name.en' => 'required|max:190|unique:articles,name',
            'name.'.config("settings.default_language").'' => 'required|max:190',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.'.config("settings.default_language").'' => 'required',
            'image' => 'required',
        ];
        return $rules;
    }

    public function updateArticle()
    {
        $rules = [
            'name' => 'required|array',
            'name.en' => 'required|max:190',
            'name.'.config("settings.default_language").'' => 'required|max:190',
            'content' => 'required|array',
            'content.en' => 'required',
            'content.'.config("settings.default_language").'' => 'required',
            'image' => 'required',

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
            'name.en.required' => __('The Title in English field is required'),
            'name.en.unique' => __('An article with same title already exists.'),
            'name.'.config("settings.default_language").'.required' => __('The Title In '.getLanguage(config("settings.default_language")).' field is required'),
            'name.ar.unique' => __('An article with same title already exists.'),
            'content.'.config("settings.default_language").'.required' =>   __('The Content In '.getLanguage(config("settings.default_language")).' field is required'),
            'content.en.required' => __('The Content In English field is required'),
            'image.required' => __('The Article Image field is required'),
        ];
    }


}

