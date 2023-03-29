<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        if ($routeName == 'front.dashboard.project.save' || $routeName == 'api.auth.project.save') {
            $rules = $this->SaveProjectRequest();
        }
        if ($routeName == 'api.supplier-portfolio') {
            $rules = $this->GetPortfolioRequest();
        }
        return $rules;
    }

    public function GetPortfolioRequest()
    {
        return [
            'supplier_id' => 'required|exists:projects,user_id',
        ];
    }

    public function SaveProjectRequest()
    {
        return [

            'name' => 'required|array',
            'name.en' => 'required|string|max:100',
            'name.'.config("settings.default_language").'' => 'required|string|max:100',
            'description' => 'required|array',
            'description.en' => 'required',
            'description.'.config("settings.default_language").'' => 'required',
            'project_images' => 'required',
            'user_id' => 'required',
        ];
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }

}
