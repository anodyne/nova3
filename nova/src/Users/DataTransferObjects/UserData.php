<?php

namespace Nova\Users\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $email;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ]);
    }
}
