<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class UserRegisterDto extends DataTransferObject
{

    public int $id = 0;
    public string $user_type = 'user';
    public array $supplier_name = [];
    public ?string $user_name;
    public string $email;
    public ?string $phone;
    public ?string $password= null;
    public ?string $address = null;
    public ?float $latitude = 0.0;
    public ?float $longitude = 0.0;
    public int $city_id = 0;
    public int $category_id = 0;
    public ?string $trade_license_image = null;
    public bool $is_active = true;
    public bool $is_verified = false;
    public bool $is_id_card_verified = false;
    public array $about = ['en'=>'', 'ar'=>''];
    public ?string $image = null;
    public ?array $id_card_images = null;
    public int $package_id = 0;
    public float $visit_fee = 0;
    public ?string $google_id = null;
    public ?string $facebook_id = null;
    public ?string $fcm_token = null;


    public function __construct($args)
    {
        parent::__construct($args);
    }


    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(Request $params): self
    {
      
        $self = collect([
            'id' => $params->input('user_id'),
            'user_type' => $params->input('user_type', 'user'),
            'user_name' => $params->input('user_name'),
            'email' => $params->input('email'),
//            'email' => 'test11@test.com',
            'phone' => $params->filled('phone') ? $params->input('phone') : null,
            'password' => $params->filled('password')? $params->input('password') : null,
            'image' => $params->filled('image')? $params->input('image') : null,
            'is_active' => $params->filled('is_active')? $params->input('is_active') : true,
            'is_verified' => $params->filled('is_verified')? $params->input('is_verified') : false,
            'google_id' => $params->filled('google_id')? $params->input('google_id') : null,
            'facebook_id' => $params->filled('facebook_id')? $params->input('facebook_id') : null,
            'fcm_token' => $params->filled('fcm_token')? $params->input('fcm_token') : null,
            'address' => $params->input('address') ? $params->input('address') : null,
            'latitude' => $params->input('latitude') ? $params->input('latitude') : null,
            'longitude' => $params->input('longitude') ?  $params->input('longitude') : null,
        ]);
        if ($params->input('user_type', 'user') == 'supplier'){
            $self = $self->merge([
                'supplier_name' => $params->input('supplier_name'),
                'address' => $params->input('address') ? $params->input('address') : null,
                'latitude' => $params->input('latitude') ? $params->input('latitude') : null,
                'longitude' => $params->input('longitude') ?  $params->input('longitude') : null,
                'city_id' => $params->input('city'),
                'visit_fee' => $params->input('visit_fee',0),
                'category_id' => $params->input('category'),
                'about' => [
                    'en'=>$params->filled('about.en')?$params->input('about.en'): '',
                    'ar'=>$params->filled('about.ar')?$params->input('about.ar', ''): ''
                ],
                'is_id_card_verified' => $params->filled('is_id_card_verified')? $params->input('is_id_card_verified') : true,
                'id_card_images' => $params->filled('id_card_images')? $params->input('id_card_images') : null,
                'trade_license_image' => $params->filled('trade_license_image')? $params->input('trade_license_image') : null,
                'package_id' => $params->input('package_id',0),
            ]);
        }
        if ($params->input('is_id_card_verified')==null){
            if ($params->input('user_id') == 0){
               $self =  $self->replace(['is_id_card_verified'=>null]);
            }
        }
        if ($params->filled('google_id') || $params->filled('facebook_id')){
            if ($params->input('user_id') == 0){
               $self =  $self->replace(['is_verified'=>true]);
               $self =  $self->replace(['is_id_card_verified'=>null]);
            }
        }
        return new self($self->toArray());

    }

}
