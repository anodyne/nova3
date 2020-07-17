<?php

namespace Nova\PostTypes\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PostTypeData extends DataTransferObject
{
    public string $name;

    public string $key;

    public ?string $description;

    public bool $active;

    public Fields $fields;

    public Options $options;

    public ?int $role_id;

    public string $visibility;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'active' => (bool) $request->active,
            'description' => $request->description,
            'fields' => Fields::fromArray($request->fields),
            'key' => $request->key,
            'name' => $request->name,
            'options' => Options::fromArray($request->options),
            'role_id' => (int) $request->role_id,
            'visibility' => $request->visibility,
        ]);
    }
}
