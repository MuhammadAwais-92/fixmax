<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class AddEquipmentDto extends DataTransferObject
{
    public int $id = 0;
    public array $name = [];
    public int $user_id = 0;
    public int $service_id = 0;
    public ?string $image = null;
    public ?string $equipment_model = null;
    public ?string $make = null;
    public float $price;


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
            'name' => $params->input('name'),
            'user_id' => $params->input('user_id'),
            'service_id' => $params->input('service_id'),
            'price' => $params->input('price'),
            'equipment_model' => $params->filled('equipment_model')? $params->input('equipment_model') : null,
            'make' => $params->filled('make')? $params->input('make') : null,
            'image' => $params->filled('image')? $params->input('image') : null,
        
        ]);

        return new self($self->toArray());
    }

}
