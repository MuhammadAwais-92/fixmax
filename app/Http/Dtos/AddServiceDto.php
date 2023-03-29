<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Carbon\Carbon;


class AddServiceDto extends DataTransferObject
{
    public int $id = 0;
    public array $name = [];
    public int $user_id = 0;
    public string $service_type = 'add-on';
    public int $category_id = 0;
    public array $description = [];
    public float $min_price;
    public float $max_price;
    public ?string $expiry_date=null;
    public ?float $discount=0;
    public ?array $service_images = null;
    public ?int $featured_subscription = 0;

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
            'id' => $params->input('id') ?? 0,
            'name' => $params->input('name'),
            'description' =>$params->input('description'),
            'user_id' => $params->input('user_id'),
            'category_id' => $params->input('category_id'),
            'max_price' => $params->input('max_price'),
            'min_price' => $params->input('min_price'),
            'discount' => $params->filled('discount') && $params->input('discount') > 0 ? $params->input('discount'): 0,
            'featured_subscription' => $params->filled('featured_subscription') ? $params->input('featured_subscription') : 0,
            'service_images' => $params->filled('service_images') ? $params->input('service_images') : null,
        ]);
        if ($params->input('discount') > 0 ){
            $today=Carbon::parse(now())->format("Y-m-d");
            $self = $self->merge([
                'expiry_date' => $today == $params->input('expiry_date') ? 'null' : DateToUnixformat($params->input('expiry_date')),
                'service_type' =>'offer',

            ]);
          
        }
        return new self($self->toArray());
    }

}
