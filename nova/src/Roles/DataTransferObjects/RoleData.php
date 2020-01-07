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
    public $title;

    /**
     * @var  array
     */
    public $abilities;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'title' => $request->get('title'),
            'name' => $request->get('name'),
            'abilities' => $request->get('abilities'),
        ]);
    }
}
