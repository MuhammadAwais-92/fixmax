<?php

namespace App\Http\Dtos;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class AddProjectDto extends DataTransferObject
{
    public int $id = 0;
    public array $name = [];
    public int $user_id = 0;
    public array $description = [];
    public ?array $project_images = null;

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
            'description' =>$params->input('description'),
            'user_id' => $params->input('user_id'),
            'project_images' => $params->filled('project_images') ? $params->input('project_images') : null,
        ]);
        return new self($self->toArray());
    }
}
