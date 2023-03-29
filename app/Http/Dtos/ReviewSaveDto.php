<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class ReviewSaveDto extends DataTransferObject
{
    public int $id = 0;
    public int $user_id;
    public int $supplier_id = 0;
    public int $service_id = 0;
    public int $order_id;
    public float $rating = 0.0;
    public ?string $review = null;
    public bool $is_reviewed = false;

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
            'id' => $params->input('id', 0),
            'user_id' => $params->input('user_id'),
            'supplier_id' => $params->input('supplier_id',0),
            'order_id' => $params->input('order_id',0),
            'service_id' => $params->input('service_id',0),
            'rating' => $params->input('rating',0.0),
            'review' => $params->filled('review')?$params->input('review'):null,
            'is_reviewed' => $params->input('is_reviewed', false),
        ]);
        return new self($self->toArray());
    }
    public static function fromCollection(Collection $params): self
    {
        $self = collect([
            'id' => $params->get('id', 0),
            'user_id' => $params->get('user_id'),
            'supplier_id' => $params->get('supplier_id',0),
            'service_id' => $params->get('service_id',0),
            'order_id' => $params->get('order_id',0),
            'rating' => $params->get('rating',0.0),
            'review' => $params->has('review')?$params->get('review'):null,
            'is_reviewed' => $params->get('is_reviewed', false),
        ]);
        return new self($self->toArray());
    }

}
