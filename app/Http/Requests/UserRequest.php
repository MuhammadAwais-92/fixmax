<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        //        dd($routeName);
        $rules = [];
        /*Admin Routes*/
        if ($routeName == 'admin.dashboard.users.update') {
            $rules = $this->validateUserUpdateRequest();
        }
        if ($routeName == 'admin.dashboard.suppliers.update') {
            $rules = $this->validateUserUpdateRequest();
        }

        /*Api Routes*/
        if ($routeName == 'api.auth.register') {
            $rules = $this->validateRegisterApiRequest();
        }
        if ($routeName == 'api.auth.login') {
            $rules = $this->validateLoginRequest();
        }
        if ($routeName == 'api.auth.verify-email') {
            $rules = $this->validateEmailVerificationRequest();
        }
        if ($routeName == 'api.auth.forgot-password') {
            $rules = $this->validateForgotPasswordCodeRequest();
        }
        if ($routeName == 'api.auth.reset-password') {
            $rules = $this->validateForgotPasswordRequest();
        }
        if ($routeName == 'api.auth.change-password') {
            $rules = $this->validateUpdatePasswordRequest();
        }
        if ($routeName == 'api.auth.update.profile') {
            $rules = $this->validateProfileUpdateRequest();
        }

        /*Front routes*/
        if ($routeName == 'front.auth.register.submit') {
            $rules = $this->validateRegisterRequest();
        }
        if ($routeName == 'front.auth.verification.submit') {
            $rules = $this->validateEmailVerificationRequest();
        }
        if ($routeName == 'front.auth.forgot-password.submit') {
            $rules = $this->validateForgotPasswordCodeRequest();
        }
        if ($routeName == 'front.dashboard.update.profile') {
            $rules = $this->validateProfileUpdateRequest();
        }
        if ($routeName == 'front.dashboard.update.password') {
            $rules = $this->validateUpdatePasswordRequest();
        }
        if ($routeName == 'front.auth.covered.areas') {
            $rules = $this->validateCoveredAreasRequest();
        }

        return $rules;
    }

    public function validateRegisterApiRequest()
    {
        $rules = collect([
            'user_type' => 'required|in:user,supplier',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
         
            'password' => 'required|confirmed',
            // 'image' => 'required',
            'terms_conditions' => 'required',
            // 'code' => 'required',
        ]);
        if ($this->get('user_type', 'user') == 'user') {
            $rules = $rules->merge([
                'user_name' => 'required',
            ]);
        }

        if ($this->get('user_type', 'user') == 'supplier') {
            $rules = $rules->merge([
                'phone' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required|exists:cities,id',
                'category' => 'required|exists:categories,id',
                'supplier_name' => 'required|array',
                'supplier_name.en' => 'required',
                'trade_license_image' => 'required',
                'image' => 'required',
                // 'id_card_images' => 'required|array',
                // 'id_card_images.0' => 'required',
                // 'id_card_images.1' => 'required'
            ]);
        }


        return $rules->toArray();
    }
    public function validateRegisterRequest()
    {
        $rules = collect([
            'user_type' => 'required|in:user,supplier',
            'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required',
            'password' => 'required|confirmed',
            // 'image' => 'required',
            'terms_conditions' => 'required',
            // 'code' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        if ($this->get('user_type', 'user') == 'user') {
            $rules = $rules->merge([
                'user_name' => 'required',
            ]);
        }

        if ($this->get('user_type', 'user') == 'supplier') {
            $rules = $rules->merge([
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required|exists:cities,id',
                'category' => 'required|exists:categories,id',
                'supplier_name' => 'required|array',
                'supplier_name.en' => 'required',
                'trade_license_image' => 'required',
                'image' => 'required',
                // 'id_card_images' => 'required|array',
                // 'id_card_images.0' => 'required',
                // 'id_card_images.1' => 'required'
            ]);
        }


        return $rules->toArray();
    }

    public function validateLoginRequest()
    {
        $rules = collect([
            'email' => 'required_without_all:google_id,facebook_id|email',
            'password' => 'required_without_all:google_id,facebook_id',
            'google_id' => 'required_without_all:email,password,facebook_id',
            'facebook_id' => 'required_without_all:email,password,google_id',
            'fcm_token' => 'required',

        ]);

        return $rules->toArray();
    }

    public function validateUserUpdateRequest()
    {
        $rules = collect([
            'user_id' => 'required',
            'user_type' => 'required|in:user,supplier',
            'phone' => 'required',
            'terms_conditions' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            // 'longitude' => 'required',
        ]);
        if ($this->get('user_id') == 0 || $this->get('user_id') == null) {
            $rules = $rules->merge([
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
            ]);
        } else {
            $rules = $rules->merge([
                'email' => 'required|email',
            ]);
        }
        if ($this->get('user_id') == 0 || $this->get('user_id') == null) {
            $rules = $rules->merge([
                'image' => 'required',
                'password' => 'required|confirmed',
            ]);
        }
        if ($this->get('user_type', 'user') == 'supplier') {
            $rules = $rules->merge([
                'address' => 'required',
                'latitude' => 'required',
                // 'longitude' => 'required',
                'city' => 'required|exists:cities,id',
                'visit_fee' => 'required',
                'supplier_name' => 'required|array',
                'supplier_name.en' => 'required',
                'supplier_name.'.config("settings.default_language").'' => 'required',

            ]);
            if ($this->get('user_id') == 0) {
                $rules = $rules->merge([
                    // 'id_card_images' => 'required|array',
                    // 'id_card_images.0' => 'required',
                    // 'id_card_images.1' => 'required'
                ]);
            }
        }
        if ($this->get('user_type', 'user') == 'user') {
            $rules = $rules->merge([
                'user_name' => 'required',

            ]);
        }
        return $rules->toArray();
    }

    public function validateCoveredAreasRequest()
    {
        $rules = collect([
            "estimated_time.0" => "required",
        ]);

        return $rules->toArray();
    }

    public function validateEmailVerificationRequest()
    {
        $rules = collect([
            'verification_code' => 'required',
        ]);

        return $rules->toArray();
    }

    public function validateForgotPasswordRequest()
    {
        $rules = collect([
            'email' => 'required',
            'verification_code' => 'required|integer',
            'password' => 'required|min:6|confirmed',
        ]);

        return $rules->toArray();
    }

    public function validateForgotPasswordCodeRequest()
    {
        $rules = collect([
            'email' => 'required',
        ]);

        return $rules->toArray();
    }

    public function validateProfileUpdateRequest()
    {
        //    $this->dd();
        $rules = collect([
            'user_type' => 'required|in:user,supplier',
            'email' => 'required|email',
            'phone' => 'required',
            // 'image' => 'required',
            'password' => 'nullable|confirmed',

        ]);
        if ($this->get('user_type', 'supplier') == 'user') {
            $rules = $rules->merge([
                'user_name' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
        }
        if ($this->get('user_type', 'user') == 'supplier') {
            $rules = $rules->merge([
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'city' => 'required|exists:cities,id',
                'supplier_name' => 'required|array',
                'supplier_name.en' => 'required',
                'supplier_name.'.config("settings.default_language").'' => 'required',
                'trade_license_image' => 'required',
                'visit_fee' => 'required'
                // 'id_card_images' => 'required|array',
                // 'id_card_images.0' => 'required',
                // 'id_card_images.1' => 'required'
            ]);
        }

        return $rules->toArray();
    }

    public function validateUpdatePasswordRequest()
    {
        $rules = collect([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        return $rules->toArray();
    }

    public function attributes()
    {
        return trans('validation')['attributes'];
    }


    public function messages()
    {
        return [
            'id_card_images.0.required' => __('Id card images are required'),
            'id_card_images.1.required' => __('Id card images are required'),
            'estimated_time.0.required' => __('Add Estimated Time  for at least one area'),
            'supplier_name.en.required' => __('Name in English is required'),
            'supplier_name.'.config("settings.default_language").'.required' => __('Name in '.getLanguage(config("settings.default_language")).' is required'),
            'user_name.en.required' => __('Name in English is required'),
            'user_name.ar.required' => __('Name in Arabic is required'),
            'latitude.required' => __('Please select a valid address from the suggestions or map.'),
        ];
    }
}
