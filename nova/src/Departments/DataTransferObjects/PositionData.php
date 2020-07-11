<?php

namespace Nova\Departments\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Departments\Models\Department;
use Spatie\DataTransferObject\DataTransferObject;

class PositionData extends DataTransferObject
{
    public string $name;

    public ?string $description;

    public int $available = 0;

    public bool $active = true;

    public Department $department;

    public int $department_id = 0;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'active' => $request->active ?? true,
            'available' => $request->available,
            'department' => Department::find($request->department_id),
            'department_id' => $request->department_id,
            'description' => $request->description,
            'name' => $request->name,
        ]);
    }
}
