<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class UserProfileUpdateDto extends DataTransferObject
{

    public int $id = 0;
    public string $user_type = 'user';
    public array $supplier_name = [];
    public ?string $user_name;
    public string $phone;
    public ?string $address = null;
    public ?string $password= null;
    public ?string $trade_license_image = null;
    public float $latitude = 0.0;
    public float $longitude = 0.0;
    public int $city_id = 0;
    public ?float $visit_fee = null;
    public array $about = ['en'=>'', 'ar'=>''];
    public ?string $image = null;
    public ?array $id_card_images = null;

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
            'phone' => $params->input('phone'),
            'image' => $params->filled('image')? $params->input('image') : null,
            'password' => $params->filled('password')? $params->input('password') : null,
            'address' => $params->input('address'),
            'latitude' => $params->input('latitude'),
            'longitude' => $params->input('longitude'),
        ]);
        if ($params->input('user_type', 'user') == 'supplier'){
            $self = $self->merge([
                'supplier_name' => $params->input('supplier_name'),
                'address' => $params->input('address'),
                'visit_fee' => $params->input('visit_fee'),
                'latitude' => $params->input('latitude'),
                'longitude' => $params->input('longitude'),
                'trade_license_image' => $params->filled('trade_license_image')? $params->input('trade_license_image') : null,
                'city_id' => $params->input('city'),
                // 'about' => [
                //     'en'=>$params->filled('about.en')?$params->input('about.en'): '',
                //     'ar'=>$params->filled('about.ar')?$params->input('about.ar', ''): ''
                // ],
                // 'id_card_images' => $params->filled('id_card_images')? $params->input('id_card_images') : null,
            ]);
        }

        return new self($self->toArray());
    }

}
