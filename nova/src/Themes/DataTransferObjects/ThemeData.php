<?php

namespace Nova\Themes\DataTransferObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ThemeData extends DataTransferObject
{
    /**
     * @var  string
     */
    public $name;

    /**
     * @var  string
     */
    public $location;

    /**
     * @var  string
     */
    public $credits;

    public static function fromRequest(Request $request): self
    {
        return new self([
            'name' => $request->get('name'),
            'location' => $request->get('location'),
            'credits' => $request->get('credits'),
        ]);
    }
}
