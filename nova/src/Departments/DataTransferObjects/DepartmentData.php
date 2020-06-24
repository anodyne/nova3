<?php

namespace Nova\Departments\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class DepartmentData extends DataTransferObject
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
     * @var  bool
     */
    public $active = true;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->name,
            'description' => $request->description,
            'active' => $request->active ?? true,
        ]);
    }
}
