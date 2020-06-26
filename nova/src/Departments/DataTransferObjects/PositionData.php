<?php

namespace Nova\Departments\DataTransferObjects;

use Illuminate\Http\Request;
use Nova\Departments\Models\Department;
use Spatie\DataTransferObject\DataTransferObject;

class PositionData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $description;

    /**
     * @var  int
     */
    public $available;

    /**
     * @var  bool
     */
    public $active = true;

    /**
     * @var  Department
     */
    public $department;

    /**
     * @var  int
     */
    public $department_id;

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
