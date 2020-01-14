<?php

namespace Nova\Roles\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class RoleData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $display_name;

    /**
     * @var  string
     */
    public $description;

    /**
     * @var  array
     */
    public $permissions;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'description' => $request->get('description'),
            'display_name' => $request->get('display_name'),
            'name' => $request->get('name'),
            'permissions' => $request->get('permissions'),
        ]);
    }
}
