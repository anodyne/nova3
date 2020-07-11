<?php

namespace Nova\Departments\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class DepartmentData extends DataTransferObject
{
    public string $name;

    public ?string $description;

    public bool $active = true;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'active' => (bool) $request->active ?? true,
            'description' => $request->description,
            'name' => $request->name,
        ]);
    }
}
