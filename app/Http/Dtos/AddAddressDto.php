<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class AddAddressDto extends DataTransferObject
{
    public int $id = 0;
    public string $address_name ;
    public int $user_id = 0;
    public string $user_phone;
    public string $address;
    public float $latitude = 0.0;
    public float $longitude = 0.0;


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
            'id' => $params->input('id'),
            'user_phone' => $params->input('user_phone'),
            'address_name' =>  $params->input('address_name'),
            'user_id' => $params->input('user_id'),
            'address' => $params->input('address'),
            'latitude' => $params->input('latitude'),
            'longitude' => $params->input('longitude'),
        
        ]);

        return new self($self->toArray());
    }

}
