<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;


class CartRequest extends FormRequest
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

        if ($routeName == 'front.add.cart' || $routeName == 'api.auth.add.cart') {
            $rules = $this->checkUpdateRequest();
        }
        if ($routeName == 'api.auth.cart.data') {
            $rules = $this->getCartDataRequest();
        }
        return $rules;
    }

    public function checkUpdateRequest()
    {
        // dd(request()->all(),Carbon::now()->format('h:i A'));
        $rules = collect([
            // 'date' => 'required|after_or_equal:today',
            'date' => 'required',
            'time' => $this->all()['date'] > date("d/m/Y") == true ? 'required|date_format:h:i A' : 'required|date_format:h:i A|after:' . Carbon::now()->format('h:i A'),
            'service_id' => 'required',
            'description' => 'required',
            'issue_images' => 'required',
            'issue_type' => 'required',
        ]);
        if ($this->get('issue_type') == 'know') {
            $rules = $rules->merge([
                'equipment' => 'required|array',
                'equipment.*.equipment_id' => 'required',
                'equipment.*.quantity' => 'required',
            ]);
        }

        return $rules->toArray();
    }

    public function getCartDataRequest()
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:carts,service_id',
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
            'question.ar.required' => __('The Question In Arabic field is required'),
            'answer.en.required' => __('The Answer In English field is required'),
            'answer.ar.required' => __('The Answer In English field is required'),
        ];
    }
}

